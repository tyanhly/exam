<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('hello');
// });


Route::get('login',[
    'as' => 'user.getLogin',
    'uses' => 'UserController@getLogin'
]);

Route::get('test',[
    'as' => 'test',
    'uses' => 'HomeController@getTest'
]);


Route::get('error/{page}',function($page){
    return View::make('errors.' . $page);
});

Route::group(['before' => 'csrf'], function(){

    Route::post('login',[
        'as' => 'user.postLogin',
        'uses' => 'UserController@postLogin'
    ]);
    
});
    
Route::group(['before' => 'auth'], function(){
    
    Route::get('logout',[
        'as' => 'user.getLogout',
        'uses' => 'UserController@getLogout'
    ]);
    
    Route::get('',[
        'as' => 'product.index',
        'uses' => 'ProductController@index'
    ]);

    Route::get('cart',[
        'as' => 'cart.index',
        'uses' => 'CartController@index'
    ]);
    
    Route::group(['before' => 'csrf'], function(){
        
        Route::post('cart/add',[
            'as' => 'cart.add',
            'uses' => 'CartController@addToCart'
        ]);
        Route::post('cart/delete',[
            'as' => 'cart.delete',
            'uses' => 'CartController@delete'
        ]);
    
        Route::post('cart/check-coupon',[
            'as' => 'cart.checkCoupon',
            'uses' => 'CartController@checkCoupon'
        ]);
        Route::post('cart/order',[
            'as' => 'cart.order',
            'uses' => 'CartController@order'
        ]);

    });
    
});