<?php

Auth::routes(['verify' => true]);

Route::get('/orders', 'OrdersController@index')->name('orders');

Route::get('/orders/{id}', 'OrdersController@order')->middleware(['logged.in', 'new.order']);
Route::post('/orders/{id}', 'OrdersController@add_proposal')->name('order');

Route::get('/add_order', 'OrdersController@add_order')->middleware('is.customer')->name('add_order');
Route::post('/add_order', 'OrdersController@save_order')->name('save_order');

Route::get('/customers', 'UsersController@customers')->name('customers');

Route::get('/workers', 'UsersController@workers')->name('workers');

Route::get('/profile', 'UsersController@profile')->middleware('logged.in')->name('profile');
Route::post('/profile', 'UsersController@save_info')->name('save_info');

Route::get('/profile/{id}', 'UsersController@user')->name('user');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware('is.admin');
