<?php

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

        $validatorRules = array(
            'coupon' => 'required|numeric'
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
}