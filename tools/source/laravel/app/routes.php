<?php

Route::get('', [
    'as' => 'dashboard',
    'uses' => 'IndexController@dashboard'
]);
Route::get('about', [
    'as' => 'dashboard',
    'uses' => 'IndexController@about'
]);
