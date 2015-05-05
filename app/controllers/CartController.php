<?php

class CartController extends \BaseController
{

    public function addToCart(){
        $validatorRules = array(
            'id' => 'required|Integer',
            'quantity' => 'required|min:1',
        );
        $validator = Validator::make(Input::all(), $validatorRules);
        
        if ($validator->fails())
        {
            return Redirect::to('/')
                ->with('error-message', 'Oops! Something went wrong while submitting the form :(');
        }
        $id = Input::get('id');
        $product = Product::find($id);
        if(!$product){
            return Redirect::to('/')
            ->with('error-message', 'Oops! Something went wrong while submitting the form :(');
        }
        
        
    }

}