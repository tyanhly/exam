<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testAddItemSuccess
 *         testAddItemFromProductSuccess
 *        
 */
class CartTest extends TestCase
{

    public function setUp () {

        parent::setUp();
        $user = new User();
        $user->user_name = 'tyanhly';
        $user->first_name = 'Ly';
        $user->last_name = 'Tung';
        $user->password = hash('sha256', '123456');
        $this->be($user); // You are now authenticated
    }

    public function testAddItemSuccess () {

        $this->console("testAddItemSuccess");
        $product1 = Product::find(1);
        
        Cart::setCartEntity(new CartEntity());
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $this->assertTrue(Cart::getCartEntity()->isExistedItem($item));
    }

    public function testAddItemFromProductSuccess () {

        $this->console("testAddItemFromProductSuccess");
        $product = Product::find(2);
        Cart::setCartEntity(new CartEntity());
        Cart::addItemFromProduct($product, 1);
        $this->assertTrue(Cart::getCartEntity()->isExistedItem(new CartItemEntity($product, 1)));
    }
    
    public function testRemoveItemSuccess(){
        $this->console("testRemoveItemSuccess");
        $product1 = Product::find(1);
        
        Cart::setCartEntity(new CartEntity());
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $this->assertTrue(Cart::getCartEntity()->isExistedItem($item));
        
        Cart::removeItem($item);
        $this->assertTrue(!Cart::getCartEntity()->isExistedItem($item));
        
    }
    

    public function testRemoveItemFromProductSuccess () {

        $this->console("testRemoveItemFromProductSuccess");
        $product1 = Product::find(1);
        
        Cart::setCartEntity(new CartEntity());
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $this->assertTrue(Cart::getCartEntity()->isExistedItem($item));
        
        Cart::removeItemFromProduct($product1);
        $this->assertTrue(!Cart::getCartEntity()->isExistedItem($item));
        
        
    }
    

    public function testOrderSuccessDontHaveCoupon(){
        $this->console("testOrderSuccessDontHaveCoupon");

        Cart::setCartEntity(new CartEntity());
        $product1 = Product::find(1);
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $userId = 1;
        
        $id = Cart::order($userId, "add test");
        $this->assertNotNull($id);
    }

    public function testOrderSuccessHaveCoupon(){
        $this->console("testOrderSuccessHaveCoupon");

        Cart::setCartEntity(new CartEntity());
        $product1 = Product::find(1);
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $userId = 1;
        
        $coupon = Coupon::find(1);
        $coupon->status=1;

        $id = Cart::order($userId, "add test", $coupon);
        $this->assertNotNull($id);
    
    }
    
    public function testOrderTransactionRollback(){
        $this->console("testOrderTransactionRollback");
        $this->setExpectedException(
                'Exception');
        Cart::setCartEntity(new CartEntity());
        $product1 = Product::find(1);
        $item = new CartItemEntity($product1, 1);
        Cart::addItem($item);
        $userId = 1;
    
        $coupon = Coupon::find(1);
        $coupon->status=1;
    
        $id = Cart::order("testUserIdWrong", "add test", $coupon);
    
    }
    
    public function testOrderWhenNumberOfItemLessOneShouldThrowCartException(){
        $this->console("testOrderWhenNumberOfItemLessOneShouldThrowCartException");
        $this->setExpectedException(
                'CartException');
        $userId = 1;

        Cart::setCartEntity(new CartEntity());
        Cart::order($userId, "test");
        
    }
    
    public function testEncryptDescryptWhenTextIsEmpty(){
        $this->console("testEncryptDescryptWhenTextIsEmpty");
        $testString = '';
        $en = Cart::encrypt($testString);
        $de = Cart::decrypt($en);
        $this->assertEquals($testString, $de);
    }

    public function testEncryptDescryptWhenTextHas10000Char(){
        $this->console("testEncryptDescryptWhenTextHas1000Chars");
        $testString = '';
        for($i=0;$i<1000;$i++){
            $testString .= '0123456789';
        }
        $en = Cart::encrypt($testString);
        $de = Cart::decrypt($en);
        $this->assertEquals($testString, $de);
    }
    

    public function testEncryptDescryptWhenTextHasSpecialChars(){
        $this->console("testEncryptDescryptWhenTextHasSpecialChars");
        $testString = "`~!@#~$%^&*()_+}{[]'\\|/\":;<>?|" ;
        $en = Cart::encrypt($testString);
        $de = Cart::decrypt($en);
        $this->assertEquals($testString, $de);
    }
    
}
