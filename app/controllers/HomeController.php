<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	
	public function getTest(){
	    echo '<pre>';
	    $en = Cart::encrypt("hehehe dasf3 dsf as r34rdf das asfdasfas!{%$}{^(_)*&_34[l; m34v4 p4fcsvxczv vxczv4124#@#@$#B#V#%#5");
	    echo $en . '<br />';

// 	    $de = Cart::decrypt($en);
	    $de = Cart::decrypt("JJgr5ySe6/wCLpEKpsMLKnP99isGB4eCpI2yf411cq2r/1QZNmim94Zf9tiByN9dwlyMz0aPUK6l3uBKzHGvPrVRjrJ8zrjOs7t1UQd4wMS2yFCDA7ekRGJLYkqxRNNnqhDjQADiuDbdLFtdZ3jY5Q==");
	    
	    echo $de;
	    die;
	}

}
