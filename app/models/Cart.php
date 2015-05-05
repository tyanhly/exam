<?php

class Cart 
{
    public function addProduct($product){
        
    }

    public static function getCart(){
        Session::get('cart', new CartEntity());
    }

    public static function setCart(CartEntity $cartEntity){
        Session::set('cart', $cartEntity);
    }
    
}

