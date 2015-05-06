<?php

/**
 *
 * @author Tung Ly
 *        
 */
class CartItemEntity
{

    protected $_product;

    protected $_quantity;

    /**
     *
     * @param Product $_product            
     * @param number $quantity            
     * @author Tung Ly
     */
    public function CartItemEntity (Product $product, $quantity) {
        $this->_product = $product;
        $this->_quantity = $quantity;
    }

    /**
     *
     * @return Product
     * @author Tung Ly
     */
    public function getProduct () {
        return $this->_product;
    }

    /**
     *
     * @param Product $product            
     * @author Tung Ly
     */
    public function setProduct (Product $product) {
        $this->_product = $product;
    }

    /**
     *
     * @return number
     * @author Tung Ly
     */
    public function getQuantity () {
        return $this->_quantity;
    }

    /**
     *
     * @param number $quantity            
     * @author Tung Ly
     */
    public function setQuantity ($quantity) {
        $this->_quantity = $quantity;
    }

}

