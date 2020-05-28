<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::post('/cabinet-login', 'CabinetController@cabinetLogin')->middleware('guest')->name('cabinet-login');
Route::get('/cabinet-request', 'CabinetController@cabinetRequest')->name('cabinet-request');

//Route::get('/role_select', function (){return view('auth.role');})->name('role-select');
Route::post('/role-selected', 'UsersController@roleSelect')->name('role-selected');

Route::get('/orders', 'OrdersController@index')->name('orders');
Route::post('/save_order', 'OrdersController@save_order')->name('save_order');
Route::post('/filter', 'OrdersController@filter');

Route::get('/orders/{id}', 'OrdersController@order')->middleware(['new.order']);
Route::post('/add_proposal/{id}', 'OrdersController@add_proposal')->name('add_proposal');
Route::post('/delete_proposal', 'OrdersController@delete_proposal')->name('delete_proposal');
Route::post('/select_worker/{id}', 'OrdersController@select_worker')->name('select_worker');
Route::post('/finish_order/{id}', 'OrdersController@finish_order')->name('finish_order');
Route::post('/change_worker/{id}', 'OrdersController@change_worker')->name('change_worker');
Route::post('/edit_order/{id}', 'OrdersController@edit_order')->name('edit_order');
Route::post('/get_files/{id}', 'OrdersController@get_files')->name('get_files');
Route::post('/delete_file/{id}', 'OrdersController@delete_file')->name('delete_file');
Route::post('/delete_order', 'OrdersController@delete_order')->name('delete_order');

Route::get('/workers', 'UsersController@workers')->name('workers');
Route::get('/customers', 'UsersController@workers')->name('customers');

Route::get('/profile', 'UsersController@profile')->name('profile');
Route::get('/password_change', 'UsersController@password_change')->middleware('logged.in')->name('password_change');
Route::post('/save_info', 'UsersController@save_info')->name('save_info');
Route::post('/save_skills', 'UsersController@save_skills')->name('save_skills');
Route::post('/change_pass', 'UsersController@change_pass')->name('change_pass');
Route::post('/save_review/{id}', 'UsersController@save_review')->name('save_review');
Route::get('/profile/{id}', 'UsersController@user')->name('user');
Route::get('/my_orders', 'UsersController@user')->middleware('logged.in')->name('my_orders');
Route::get('/settings', 'UsersController@settings')->middleware('logged.in')->name('settings');
Route::post('/save_settings', 'UsersController@save_settings')->name('save_settings');

Route::get('/', 'HomeController@index');
Route::get('/tutorial', 'HomeController@tutorial')->name('tutorial');

Route::get('/admin', 'AdminController@index')->middleware('is.admin')->name('admin');
Route::post('/ban_user', 'AdminController@ban')->name('ban');
Route::post('/unban_user', 'AdminController@unban')->name('unban');
Route::post('/finish', 'AdminController@finish_order')->name('finish');
Route::post('/delete', 'AdminController@delete_order')->name('delete');
Route::post('/new_user', 'AdminController@new_user')->name('new_user');
Route::post('/save_dept', 'AdminController@save_dept')->name('save_dept');
Route::post('/save_categ', 'AdminController@save_categ')->name('save_categ');
Route::post('/send_application', 'AdminController@send_application')->name('send_application');
Route::post('/accept_application/{id}', 'AdminController@accept_application')->name('accept_application');
Route::post('/reject_application/{id}', 'AdminController@reject_application')->name('reject_application');

Route::get('/chat', 'ChatController@index')->middleware('logged.in')->name('to_chat');
Route::post('/chat', 'ChatController@new_message')->name('new_message');
Route::post('/get_messages', 'ChatController@get_messages');
Route::post('/new_contact', 'ChatController@new_contact')->name('new_contact');
Route::post('/check_messages', 'ChatController@check_messages');
Route::post('/check_header', 'ChatController@check_header');
Route::post('/send_file', 'ChatController@send_file')->name('send_file');
Route::post('/get_file', 'ChatController@get_file')->name('get_file');
