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
     * @param CartItemEntity $item
     * @author Tung Ly
     */
    public static function removeItem(CartItemEntity $item)
    {
        $cartEntity = Cart::getCartEntity();
//         dd($cartEntity);die;
        $cartEntity->remove($item);
        Cart::setCartEntity($cartEntity);
    }

    /**
     * @param Product $product
     * @author Tung Ly
     */
    public static function removeItemFromProduct(Product $product)
    {
        $item = new CartItemEntity($product, 1);
        Cart::removeItem($item);
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public static function getSessionCartKey(){
        return 'cart' . Auth::user()->id;
    }
    /**
     *
     * @return CartEntity
     * @author Tung Ly
     */
    public static function getCartEntity()
    {
        if(!Auth::user())
            throw new CartException(CartException::AUTH_HAD_NOT_AUTHEN);
        return Session::get(Cart::getSessionCartKey(), new CartEntity());
    }


    /**
     *
     * @param CartEntity $cartEntity            
     * @author Tung Ly
     */
    public static function setCartEntity(CartEntity $cartEntity)
    {
        Session::set(Cart::getSessionCartKey(), $cartEntity);
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
        $discount = 0;
        $couponId = null;
        if($coupon){
            $discount = $coupon->couponType->discount;
            $couponId = $coupon->id;
        }
        try {
            $user = User::find($userId);
            if(!$user){
                throw new Exception("User is not found");
            }
            \DB::beginTransaction();
            $order = new Order();
            $order->user_id = $userId;
            $order->coupon_id = $couponId;
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
            
            //update coupon
            
            if($coupon){
                $coupon->status = 1;
                $coupon->save();
            }
            \DB::commit();
            
            Cart::setCartEntity(new CartEntity());
            return $order->id;
        } catch (Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

    /**
     * @param unknown $value
     * @return string
     * @author Tung Ly
     */
    public static function encrypt($value){
        $method = Config::get("constants.encryptMethod");
        $pass = Config::get("constants.encryptPass");
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $en=base64_encode(openssl_encrypt($value, $method, $pass, true, $iv));
        return  $en;
    }
    

    /**
     * @param unknown $value
     * @return string
     * @author Tung Ly
     */
    public static function decrypt($value){
        $method = Config::get("constants.encryptMethod");
        $pass = Config::get("constants.encryptPass");
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $de=openssl_decrypt(base64_decode($value), $method, $pass, true, $iv);
        return  $de;
    }
}

