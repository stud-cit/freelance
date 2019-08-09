<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/orders', 'OrdersController@index');
Route::get('/orders/{id}', 'OrdersController@order')->middleware(\App\Http\Middleware\LoginCheck::Class);

Route::get('/customers', 'UsersController@customers');
Route::get('/workers', 'UsersController@workers');

Route::get('/', 'HomeController@index');

Route::get('/admin', 'AdminController@index')->middleware(\App\Http\Middleware\AdminCheck::class);
