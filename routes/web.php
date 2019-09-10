<?php

Auth::routes(['verify' => true]);

Route::get('/orders', 'OrdersController@index')->name('orders');
Route::post('/orders', 'OrdersController@save_order')->name('save_order');
Route::post('/orders/sort_order', 'OrdersController@sort_order')->name('sort_order');

Route::get('/orders/{id}', 'OrdersController@order')->middleware(['logged.in', 'new.order']);
Route::post('/orders/{id}', 'OrdersController@add_proposal')->name('order');
Route::post('/orders/{id}/select_worker', 'OrdersController@select_worker')->name('select_worker');
Route::post('/orders/{id}/add_review', 'OrdersController@add_review')->name('add_review');
Route::post('/orders/{id}/edit_order', 'OrdersController@edit_order')->name('edit_order');
Route::post('/orders/{id}/delete_order', 'OrdersController@delete_order')->name('delete_order');

Route::get('/customers', 'UsersController@customers')->name('customers');

Route::get('/workers', 'UsersController@workers')->name('workers');

Route::get('/profile', 'UsersController@profile')->middleware('logged.in')->name('profile');
Route::post('/profile', 'UsersController@save_info')->name('save_info');
Route::post('/profile/save_contacts', 'UsersController@save_contacts')->name('save_contacts');
Route::post('/profile/save_skills', 'UsersController@save_skills')->name('save_skills');
Route::post('/profile/change_pass', 'UsersController@change_pass')->name('change_pass');
Route::post('/profile/save_review', 'UsersController@save_review')->name('save_review');
Route::post('/profile/save_about_me', 'UsersController@save_about_me')->name('save_about_me');

Route::get('/profile/{id}', 'UsersController@user')->name('user');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware('is.admin');
