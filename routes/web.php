<?php

Auth::routes(['register' => false]);

Route::get('/orders', 'OrdersController@index')->name('orders');
Route::post('/save_order', 'OrdersController@save_order')->name('save_order');
Route::post('/filter', 'OrdersController@filter');

Route::get('/orders/{id}', 'OrdersController@order')->middleware(['logged.in', 'new.order']);
Route::post('/add_proposal/{id}', 'OrdersController@add_proposal')->name('add_proposal');
Route::post('/delete_proposal', 'OrdersController@delete_proposal')->name('delete_proposal');
Route::post('/select_worker/{id}', 'OrdersController@select_worker')->name('select_worker');
Route::post('/finish_order/{id}', 'OrdersController@finish_order')->name('finish_order');
Route::post('/change_worker/{id}', 'OrdersController@change_worker')->name('change_worker');
Route::post('/edit_order/{id}', 'OrdersController@edit_order')->name('edit_order');
Route::post('/delete_order/{id}', 'OrdersController@delete_order')->name('delete_order');
Route::post('/get_files/{id}', 'OrdersController@get_files')->name('get_files');
Route::post('/delete_file/{id}', 'OrdersController@delete_file')->name('delete_file');

Route::get('/workers', 'UsersController@workers')->name('workers');

Route::get('/profile', 'UsersController@profile')->middleware('logged.in')->name('profile');
Route::post('/save_info', 'UsersController@save_info')->name('save_info');
Route::post('/save_contacts', 'UsersController@save_contacts')->name('save_contacts');
Route::post('/save_skills', 'UsersController@save_skills')->name('save_skills');
Route::post('/change_pass', 'UsersController@change_pass')->name('change_pass');
Route::post('/save_review/{id}', 'UsersController@save_review')->name('save_review');
Route::post('/save_about_me', 'UsersController@save_about_me')->name('save_about_me');

Route::get('/profile/{id}', 'UsersController@user')->name('user');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware('is.admin');
Route::post('/ban_user', 'AdminController@ban')->name('ban');
Route::post('/unban_user', 'AdminController@unban')->name('unban');
Route::post('/finish', 'AdminController@finish_order')->name('finish');
Route::post('/delete', 'AdminController@delete_order')->name('delete');
Route::post('/new_user', 'AdminController@new_user')->name('new_user');
Route::post('/save_dept', 'AdminController@save_dept')->name('save_dept');
Route::post('/save_categ', 'AdminController@save_categ')->name('save_categ');

Route::get('/chat', 'ChatController@index')->middleware('logged.in')->name('to_chat');
Route::post('/chat', 'ChatController@new_message')->name('new_message');
Route::post('/get_messages', 'ChatController@get_messages');
Route::post('/new_contact', 'ChatController@new_contact')->name('new_contact');
Route::post('/check_messages', 'ChatController@check_messages');
Route::post('/check_header', 'ChatController@check_header');
Route::post('/send_file', 'ChatController@send_file')->name('send_file');
Route::post('/get_file', 'ChatController@get_file')->name('get_file');

