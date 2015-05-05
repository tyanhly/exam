<?php

class CartEntity 
{
    private  $_products = array();
    
    public function CartEntity($products=array()){
        $this->_products = $products;
    }
    
    public function add(CartItemEntity $item){
        if(array_key_exists($item->product->id, $this->_products)){
            return false;
        }
        $this->_products[$item->product->id] = $item;
    }
    
    
    
}

