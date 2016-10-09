<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::auth();

Route::get('/', 'homeController@index')->name('index');

Route::group(['namespace' => 'UserControl'], function(){
	Route::resource('user-control', 'UserController');
});

Route::group(['namespace' => 'Mails'], function(){
	Route::get('message', 'MailController@message');
});

Route::group(['namespace' => 'Order'], function(){
	Route::resource('order', 'OrderController');
});