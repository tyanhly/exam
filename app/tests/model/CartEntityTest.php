<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testInitCartSuccess
 *         testAddItemHasQuantityGtThanStockQuantityShouldThrowCartException
 *         testAdd2ItemHasQuantityNotGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity
 *         testAdd2ItemHasQuantityGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity
 *         testRemoveItemIfNotExistedShouldThrowCartExeception
 *         testRemoveItemIfExistedShouldUnsetItem
 *         testGetTotalWhenDontHaveDiscount

 */
class CartEntityTest extends TestCase
{

    private $product;
    
    private $quatity;

    public function setUp () {
        parent::setUp();
        $this->product = new Product();
        $this->product->name = 'P 1';
        $this->product->code = 'P 1';
        $this->product->stock_quantity = 2;
        $this->quatity = 5;
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testInitCartSuccess () {
        $this->console("testInitCartSuccess");
        $cart = new CartEntity();
        $this->assertEquals($cart->getTotal(),0);
    }

    public function testAddItemHasQuantityGtThanStockQuantityShouldThrowCartException(){
        $this->console("testAddItemHasQuantityGtThanStockQuantityShouldThrowCartException");
        $this->setExpectedException(
                'CartException');
        $cart = new CartEntity();

        $this->product->stock_quantity = 2;
        $this->quatity = 5;
        
        $item = new CartItemEntity($this->product, $this->quatity);
        $cart->add($item);
        
    }
    
    public function testAdd2ItemHasQuantityNotGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity(){
        $this->console("testAdd2ItemHasQuantityNotGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity");
        $cart = new CartEntity();
    
        $this->product->stock_quantity = 100;
        $item1 = new CartItemEntity($this->product, 5);
        $item2 = new CartItemEntity($this->product, 3);
        $cart->add($item1);
        $befAmount = $cart->getNumberOfItems();
        
        $cart->add($item2);
        $aftAmount = $cart->getNumberOfItems();

        $this->assertEquals($befAmount,$aftAmount);
        $this->assertEquals($cart->getItems()[$this->product->id]->getQuantity(), 8);
    }
    

    public function testAdd2ItemHasQuantityGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity(){
        $this->console("testAdd2ItemHasQuantityGtThanStockQuantityAndItemHasExistedShouldAddMoreQuantity");
        $cart = new CartEntity();
    
        $this->product->stock_quantity = 10;
        $item1 = new CartItemEntity($this->product, 5);
        $item2 = new CartItemEntity($this->product, 6);
        $cart->add($item1);
        $this->assertEquals($cart->getItems()[$this->product->id]->getQuantity(), 5);
        
        $befAmount = $cart->getNumberOfItems();
        $this->setExpectedException(
                'CartException');
        $cart->add($item2);
    }
    


    public function testRemoveItemIfNotExistedShouldThrowCartExeception(){
        $this->console("testRemoveItemIfNotExistedShouldThrowCartExeception");
        $this->setExpectedException(
                'CartException');
        $cart = new CartEntity();
        $item1 = new CartItemEntity($this->product, 3);
        
        $this->product->id +=1;
        $item2 = new CartItemEntity($this->product, 3);
        $cart->remove($item2);
        
    
    }
    

    public function testRemoveItemIfExistedShouldUnsetItem(){
        $this->console("testRemoveItemIfExistedShouldUnsetItem");
        $cart = new CartEntity();
        $item = new CartItemEntity($this->product, 1);

        $cart->add($item);
        $this->assertEquals($cart->getNumberOfItems(),1);

        $cart->remove($item);
        $this->assertEquals($cart->getNumberOfItems(),0);
    
    }
    
    public function testGetTotalWhenDontHaveDiscount(){
        $this->console("testGetTotalWhenDontHaveDiscount");

        $product1 = Product::find(1);
        $quatity1 = $product1->stock_quantity;
        $product2 = Product::find(2);
        $quatity2 = $product2->stock_quantity;
        
        $item1 = new CartItemEntity($product1, $quatity1);
        $item2 = new CartItemEntity($product2, $quatity2);
        
        $respectTotal = $quatity1 * $product1->sale_price 
                      + $quatity2 * $product2->sale_price;
        $cart = new CartEntity();
        $cart->add($item1);
        $cart->add($item2);
        $product = $cart->getItems()[$item1->getProduct()->id];
        $this->assertEquals($cart->getTotal(), $respectTotal);
    }
    
}
