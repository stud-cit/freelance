<?php

Auth::routes(['verify' => true]);

Route::get('/orders', 'OrdersController@index');
Route::get('/orders/{id}', 'OrdersController@order')->middleware('logged.in');
Route::post('/orders/{id}', 'OrdersController@add_proposal')->name('add_proposal');

Route::get('/customers', 'UsersController@customers');
Route::get('/workers', 'UsersController@workers');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware('is.admin');
