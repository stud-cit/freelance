<?php

Auth::routes(['verify' => true]);



Route::get('/orders', 'OrdersController@index')->name('orders');
Route::get('/orders/{id}', 'OrdersController@order')->middleware('logged.in');
Route::post('/orders/{id}', 'OrdersController@add_proposal')->name('add_proposal');

Route::get('/customers', 'UsersController@customers')->name('customers');
Route::get('/workers', 'UsersController@workers')->name('workers');
Route::get('/profile', 'UsersController@profile')->middleware('logged.in')->name('profile');
Route::post('/profile', 'UsersController@save_info')->name('save_info');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware('is.admin');
