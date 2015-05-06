<?php

class CartEntity
{

    private $_items = array();

    /**
     *
     * @param array $items            
     * @author Tung Ly
     */
    public function CartEntity ($items = array()) {
        $this->_items = $items;
    }

    /**
     *
     * @param CartItemEntity $item            
     * @author Tung Ly
     */
    public function add (CartItemEntity $item) {
        
        if ($item->getQuantity() > $item->getProduct()->stock_quantity) {
            throw new CartException(
                    CartException::MODEL_CART_ITEM_QUANTITY_NOT_ENOUGH);
        }
        if (! $this->isExistedItem($item)) {
            $this->_items[$item->getProduct()->id] = $item;
        } else {
            $quantity = $this->_items[$item->getProduct()->id]->getQuantity() +
                     $item->getQuantity();
            if ($quantity >
                     $this->_items[$item->getProduct()->id]->getProduct()->stock_quantity) {
                throw new CartException(
                        CartException::MODEL_CART_ITEM_QUANTITY_NOT_ENOUGH);
            }
            $this->_items[$item->getProduct()->id]->setQuantity($quantity);
        }
    }

    /**
     *
     * @param CartItemEntity $item            
     * @throws CartException
     * @author Tung Ly
     */
    public function remove (CartItemEntity $item) {
        if (! $this->isExistedItem($item)) {
            throw new CartException(CartException::MODEL_CART_ITEM_NOT_EXISTED);
        } else {
            unset($this->_items[$item->getProduct()->id]);
        }
    }

    /**
     *
     * @param CartItemEntity $item            
     * @return boolean
     * @author Tung Ly
     */
    public function isExistedItem (CartItemEntity $item) {
        
        if (array_key_exists($item->getProduct()->id, $this->_items)) {
            return true;
        }
        return false;
    }

    public function getItems () {
        return $this->_items;
    }

    public function getNumberOfItems () {
        
        return count($this->_items);
    }

    public function getTotal ($discount = 0) {
        $total = 0;
        foreach ($this->_items as $item) {
            $total += $item->getQuantity() * $item->getProduct()->sale_price;
        }
        // echo count($this->_items);die;
        return $total * (100 - $discount) / 100;
    }
}

