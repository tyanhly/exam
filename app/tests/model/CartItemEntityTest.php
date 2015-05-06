<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testInitItemSuccess
 *         testGetProductRight
 *         testGetQuantityRight
 *         testSetProductRight
 *         testSetQuantityRight
 */
class CartItemEntityTest extends TestCase
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
    public function testInitItemSuccess () {
        $this->console("testInitItemSuccess");
        $item = new CartItemEntity($this->product, $this->quatity);
        $this->assertEquals($item->getQuantity(), $this->quatity);
        $this->assertEquals($item->getProduct(), $this->product);
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testGetProductRight () {
        $this->console("testGetProductRight");
        $item = new CartItemEntity($this->product, $this->quatity);
        $this->assertEquals($item->getProduct(), $this->product);
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testGetQuantityRight () {
        $this->console("testGetQuantityRight");
        $item = new CartItemEntity($this->product, $this->quatity);
        $this->assertEquals($item->getQuantity(), $this->quatity);
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testSetProductRight () {
        $this->console("testSetProductRight");
        $item = new CartItemEntity($this->product, $this->quatity);
        $p = new Product();
        $p->name ="a";
        $item->setProduct($p);
        $this->assertNotEquals($p, $this->product);
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testSetQuantityRight () {
        $this->console("testSetQuantityRight");
        $item = new CartItemEntity($this->product, $this->quatity);
        $quantity =100;
        $item->setQuantity($quantity);
        $this->assertNotEquals($quantity, $this->quatity);
    }
}
