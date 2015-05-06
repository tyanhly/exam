<?php

/**
 * @author Tung Ly
 *
 */
class Cart
{

    /**
     *
     * @param CartItemEntity $item            
     * @author Tung Ly
     */
    public static function addItem(CartItemEntity $item)
    {
        $cartEntity = Cart::getCartEntity();
        $cartEntity->add($item);
        Cart::setCartEntity($cartEntity);
    }

    public static function removeItem(CartItemEntity $item)
    {
        $cartEntity = Cart::getCartEntity();
        $cartEntity->remove($item);
        Cart::setCartEntity($cartEntity);
    }

    public static function removeItemFromProduct(Product $product)
    {
        $item = new CartItemEntity($product, 1);
        Cart::removeItem($item);
    }

    /**
     *
     * @param Product $product            
     * @param number $quantity            
     * @author Tung Ly
     */
    public static function addItemFromProduct(Product $product, $quantity = 1)
    {
        $item = new CartItemEntity($product, $quantity);
        Cart::addItem($item);
    }

    /**
     *
     * @return CartEntity
     * @author Tung Ly
     */
    public static function getCartEntity()
    {
        return Session::get('cart', new CartEntity());
    }

    public static function getCartArray()
    {
        $cart = Session::get('cart', new CartEntity());
        return $cart->toArray();
    }

    /**
     *
     * @param CartEntity $cartEntity            
     * @author Tung Ly
     */
    public static function setCartEntity(CartEntity $cartEntity)
    {
        Session::set('cart', $cartEntity);
    }

    /**
     * @param number $userId
     * @param string $address
     * @param Coupon $coupon
     * @throws CartException
     * @throws Exception
     * @return number
     * @author Tung Ly
     */
    public static function order($userId, $address, Coupon $coupon = null)
    {
        $cartEntity = Cart::getCartEntity();
        if ($cartEntity->getNumberOfItems() < 1) {
            throw new CartException(CartException::ORDER_CART_DONT_HAVE_ITEM);
        }
//         dd( $coupon->couponType());
        $discount = $coupon->couponType->discount;
        try {

            \DB::beginTransaction();
            $order = new Order();
            $order->user_id = $userId;
            $order->coupon_id = $coupon->id;
            $order->address_info = Cart::encrypt($address);
            $order->discount = $discount;
            $order->total_payment = $cartEntity->getTotal($discount);
            $order->save();
            
            foreach($cartEntity->getItems() as $item){
                $product = $item->getProduct();
                
                $orderDetail = new OrderDetail();
                $orderDetail->quantity = $item->getQuantity();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->save();
                
                $product->stock_quantity -= $item->getQuantity();
                $product->save();
                
            } 
            \DB::commit();
            return $order->id;
        } catch (Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

    public static function encrypt($value){
//         openssl_private_encrypt($data, $encryptData,
//             openssl_get_privatekey($priKey, $passphrase));
//         return base64_encode($encryptData);
        return base64_encode($value);
    }
    

    public static function decrypt($value){
//         openssl_get_publickey($pubKey);
//         openssl_public_decrypt(base64_decode($data), $decryptData,
//             openssl_get_publickey($pubKey));
//         if ($decryptData == NULL) {
//             throw new RequestException(
//                 RequestException::ERROR_RSA_CANNOT_DECRYPT);
//         }
//         return $decryptData;
        return base64_decode($value);
    }
}

