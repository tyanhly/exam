<?php

/**
 * @author Tung Ly
 *
 */
class Cart 
{
    /**
     * @param CartItemEntity $item
     * @author Tung Ly
     */
    public static function addItem(CartItemEntity $item){
        $cartEntity = Cart::getCartEntity();
        $cartEntity->add($item);
        Cart::setCartEntity($cartEntity);
    }
    
    public static function removeItem(CartItemEntity $item){
        $cartEntity = Cart::getCartEntity();
        $cartEntity->remove($item);
        Cart::setCartEntity($cartEntity);
    }

    public static function removeItemFromProduct(Product $product){
        $item = new CartItemEntity($product, 1);
        Cart::removeItem($item);
    }
    /**
     * @param Product $product
     * @param number $quantity
     * @author Tung Ly
     */
    public static function addItemFromProduct(Product $product, $quantity = 1){
        $item = new CartItemEntity($product, $quantity);
        Cart::addItem($item);
    }
    
    /**
     * @return CartEntity
     * @author Tung Ly
     */
    public static function getCartEntity(){
        return Session::get('cart', new CartEntity());
    }
    
    public static function getCartArray(){
        $cart = Session::get('cart', new CartEntity());
        return $cart->toArray();
    }
    /**
     * @param CartEntity $cartEntity
     * @author Tung Ly
     */
    public static function setCartEntity(CartEntity $cartEntity){
        Session::set('cart', $cartEntity);
    }
    
    
}

