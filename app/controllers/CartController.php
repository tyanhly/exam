<?php

use Carbon\Carbon;
class CartController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cart = Cart::getCartEntity();
        // dd($data);
        // $products = \Paginator::make($data, $count, $perPage);
        
        return View::make('cart.index', array(
            'cart' => $cart
        ));
    }

    public function addToCart()
    {
        $validatorRules = array(
            'id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1'
        );
        // dd(Input::all());
        $validator = Validator::make(Input::all(), $validatorRules);
        
        if ($validator->fails()) {
            return Redirect::route('product.index')->with('error-message', $validator->errors()
                ->first());
        }
        $id = Input::get('id');
        $quantity = Input::get('quantity');
        // dd($quantity);
        $product = Product::find($id);
        if (! $product) {
            return Redirect::route('product.index')->with('error-message', 'Product not found');
        }
        try {
            Cart::addItemFromProduct($product, $quantity);
        } catch (Exception $e) {
            if ($e->getCode() == CartException::MODEL_CART_ITEM_QUANTITY_NOT_ENOUGH) {
                $msg = "The number of {$product->name} is not enough to sell";
            } else {
                $msg = $e->getMessage();
            }
            return Redirect::route('product.index')
                ->with('error-message', $msg);
        }
        
        return Redirect::route('cart.index')->with('message', 'Add item success');
    }

    public function delete()
    {
        $validatorRules = array(
            'id' => 'required|numeric'
        );
        
        // dd(Input::all());
        $validator = Validator::make(Input::all(), $validatorRules);
        
        if ($validator->fails()) {
            return Redirect::route('cart.index')->with('error-message', $validator->errors()
                ->first());
        }
        $id = Input::get('id');
        
        $product = Product::find($id);
        if (! $product) {
            return Redirect::route('cart.index')->with('error-message', 'Product not found');
        }
        
        Cart::removeItemFromProduct($product);
        
        return Redirect::route('cart.index')->with('message', "Remove item success");
    }
    
    public function checkCoupon(){

        $couponCode = Input::get('couponCode');
        $this->_validateCoupon($couponCode);

        return Redirect::route('cart.index')->with('message', 'Coupon is valid.');
        
    }
    
    private function _validateCoupon($couponCode){

        $validatorRules = array(
            'couponCode' => 'required|alpha_num',
        );
        
        $input = array('couponCode' => $couponCode);
        $validator = Validator::make($input, $validatorRules);
        
        if ($validator->fails()) {
            return Redirect::route('cart.index')->with('error-message', $validator->errors()
                ->first());
        }
        
        $coupon = Coupon::where('code', $couponCode)->first();
        
        if (! $coupon) {
            return Redirect::route('cart.index')->with('error-message', 'Coupon does not exist.')
            ->with('couponCode', $couponCode);
        }
        
        $now = Carbon::now();
//         echo $coupon->expired_date;die;
        $expire = Carbon::createFromFormat('Y-m-d H:i:s', $coupon->expired_date);
        
        if ($now->gt($expire)) {
            return Redirect::route('cart.index')->with('error-message', 'Coupon has expired.');
        }
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $coupon->start_date);
        if ($now->lt($start)) {
            return Redirect::route('cart.index')->with('error-message', 'Coupon had not start yet.');
        }
        
        if ($coupon->status == 1){
            return Redirect::route('cart.index')->with('error-message', 'Coupon has already used.');
        
        }
        
        return true;
    }
    
    public function order(){
//         dd(\Input::all());

        $couponCode = \Input::get('couponCode',null);
        $coupon = null;
        if($couponCode){
            $valid =$this->_validateCoupon($couponCode);
            if($valid !== true){
                return $valid;
            }
            $coupon = Coupon::with('couponType')->where('code', $couponCode)->first();
        }
        $validatorRules = array(
            'address' => 'required',
        );
        
        $validator = Validator::make(\Input::all(), $validatorRules);
        
        if ($validator->fails()) {
            return Redirect::route('cart.index')->with('error-message', $validator->errors()
                ->first());
        }
        
        $orderId = Cart::order(Auth::user()->id, \Input::get('address'), $coupon);
        

        return Redirect::route('cart.index')->with('message', "Your order Id is $orderId has been received and is currently in verification process");
    }
}