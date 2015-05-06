<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testCartDetailResponseOk
 *         testAddToCartSuccess
 *         testAddToCartSuccess
 *         testAddToCartParamIsNotValid
 *         testAddToCartStockQuantityLessThanQuantity
 *         testAddToCartProductNotFound
 *         testDeleteSuccess
 *         testDeleteWithProductDidntHaveInCart
 *         testDeleteWithWrongProductId
 *         testDeleteParamIsNotValid
 *         testCheckCouponValidSuccess
 *         testCheckCouponValidSuccess
 *         testCheckCouponValidNotExisted
 *         testCheckCouponValidExpired
 *         testCheckCouponValidExpired
 *         testOrderCouponNotNullSuccess
 *         testOrderCouponNotNullSuccess
 *         testOrderWhenCartEmpty
 *         testOrderCouponNotNullSuccess
 *        
 */
class CartControllerTest extends TestCase
{

    public function __setUp () {
        $user = new User();
        $user->user_name = 'tyanhly';
        $user->first_name = 'Ly';
        $user->last_name = 'Tung';
        $user->password = hash('sha256', '123456');
        $this->be($user); // You are now authenticated
    }

    public function tearDown () {
        
        Mockery::close();
        parent::tearDown();
        Auth::logout();
    }

    /**
     *
     * @author Tung Ly
     */
    public function testCartDetailResponseOk () {
        $this->console("testCartDetailResponseOk");
        $this->__setUp();
        $this->call('GET', '/cart');
        $this->assertResponseOk();
    }

    /**
     *
     * @author Tung Ly
     */
    public function testAddToCartSuccess () {
        $this->__setUp();
        $this->console("testAddToCartSuccess");
        $product = Product::find(1);
        $product->stock_quantity = 100;
        $product->save();
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('addItemFromProduct')
            ->with($product)
            ->andReturn(true);
        
        $this->call('POST', '/cart/add', 
                array(
                    'id' => $product->id,
                    'quantity' => 1
                ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testAddToCartDontHaveAuth () {
        $this->console("testAddToCartSuccess");
        
        $product = Product::find(1);
        $product->stock_quantity = 100;
        $product->save();
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('addItemFromProduct')
            ->with($product)
            ->andReturn(true);
        
        $this->call('POST', '/cart/add', 
                array(
                    'id' => $product->id,
                    'quantity' => 1
                ));
        $this->assertRedirectedToRoute('product.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testAddToCartParamIsNotValid () {
        $this->__setUp();
        $this->console("testAddToCartParamIsNotValid");
        
        $product = Product::find(1);
        $product->stock_quantity = 100;
        $product->save();
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $this->call('POST', '/cart/add', 
                array(
                    'id' => 'dsfdfdf',
                    'quantity' => ' sdfdsf'
                ));
        $this->assertRedirectedToRoute('product.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testAddToCartStockQuantityLessThanQuantity () {
        $this->__setUp();
        $this->console("testAddToCartStockQuantityLessThanQuantity");
        
        $product = Product::find(1);
        $product->stock_quantity = 100;
        $product->save();
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('addItemFromProduct')
            ->with($product)
            ->andReturn(true);
        
        $this->call('POST', '/cart/add', 
                array(
                    'id' => $product->id,
                    'quantity' => 200
                ));
        $this->assertRedirectedToRoute('product.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testAddToCartProductNotFound () {
        $this->__setUp();
        $this->console("testAddToCartProductNotFound");
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        
        $this->call('POST', '/cart/add', 
                array(
                    'id' => 100000000,
                    'quantity' => 1
                ));
        $this->assertRedirectedToRoute('product.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testDeleteSuccess () {
        $this->__setUp();
        $this->console("testDeleteSuccess");
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('getCartEntity')->andReturn($cartE);
        
        $this->call('POST', '/cart/delete', array(
            'id' => $product->id
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testDeleteWithProductDidntHaveInCart () {
        
        $this->__setUp();
        $this->console("testDeleteWithProductDidntHaveInCart");
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $this->call('POST', '/cart/delete', array(
            'id' => $product->id
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testDeleteWithWrongProductId () {
        
        $this->__setUp();
        $this->console("testDeleteWithWrongProductId");
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $this->call('POST', '/cart/delete', array(
            'id' => 1000000000
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testDeleteParamIsNotValid () {
        $this->__setUp();
        $this->console("testDeleteParamIsNotValid");
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        
        $this->call('POST', '/cart/delete', array(
            'id' => "ErrorParamEx"
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testCheckCouponValidSuccess () {
        
        $this->__setUp();
        $coupon = Coupon::find(1);
        $coupon->status = 0;
        $coupon->save();
        
        $this->console("testCheckCouponValidSuccess");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $this->call('POST', '/cart/check-coupon', array(
            'couponCode' => "1"
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testCheckCouponValidHaveParamsIsNotValid () {
        
        $this->console("testCheckCouponValidSuccess");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        
        $this->call('POST', '/cart/check-coupon', 
                array(
                    'couponCode' => "gfg fg fg"
                ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testCheckCouponValidNotExisted () {
        
        $this->__setUp();
        
        $this->console("testCheckCouponValidNotExisted");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $this->call('POST', '/cart/check-coupon', 
                array(
                    'couponCode' => "100000000"
                ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testCheckCouponValidExpired () {
        
        $this->__setUp();
        
        $this->console("testCheckCouponValidExpired");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $this->call('POST', '/cart/check-coupon', array(
            'couponCode' => "5"
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testCheckCouponValidNotStartTimeValid () {
        
        $this->__setUp();
        
        $this->console("testCheckCouponValidExpired");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $this->call('POST', '/cart/check-coupon', array(
            'couponCode' => "2"
        ));
        $this->assertRedirectedToRoute('cart.index');
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testOrderCouponNotNullSuccess () {
        
        $this->console("testOrderCouponNotNullSuccess");
        $this->__setUp();
        
        $coupon = Coupon::find(1);
        $coupon->status = 1;
        $coupon->save();
        
        $input = array(
            'couponCode' => "1",
            'address' => "Address"
        );
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('getCartEntity')->andReturn($cartE);
        
        $this->call('POST', '/cart/order', $input);
        $this->assertRedirectedToRoute('cart.index');
    
    }

    public function testOrderCouponNullSuccess () {
        
        $this->console("testOrderCouponNotNullSuccess");
        $this->__setUp();
        
        $input = array(
            'couponCode' => null,
            'address' => "Address"
        );
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('getCartEntity')->andReturn($cartE);
        
        $this->call('POST', '/cart/order', $input);
        $this->assertRedirectedToRoute('cart.index');
    
    }

    /**
     * 
     * @author Tung Ly
     */
    public function testOrderWhenCartEmpty () {
        
        $this->console("testOrderWhenCartEmpty");
        $this->__setUp();
        
        $input = array(
            'couponCode' => null,
            'address' => "Address"
        );
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(false);
        
        $cartE = new CartEntity();
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('getCartEntity')->andReturn($cartE);
        
        $this->call('POST', '/cart/order', $input);
        $this->assertRedirectedToRoute('cart.index');
    
    }

    public function testOrderCouponFailParams () {
        
        $this->console("testOrderCouponNotNullSuccess");
        
        $input = array(
            'couponCode' => null,
            'address' => null
        );
        $product = Product::find(1);
        
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        
        $cartE = new CartEntity();
        $cartE->add(new CartItemEntity($product, 1));
        
        $card = Mockery::mock('Cart');
        $card->shouldReceive('getCartEntity')->andReturn($cartE);
        
        $this->call('POST', '/cart/order', $input);
        $this->assertRedirectedToRoute('cart.index');
    
    }
}
