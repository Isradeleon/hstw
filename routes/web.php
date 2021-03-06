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

Route::get('/generate_admin', 'UserController@admin');
Route::get('/transaction/{numero}/{pin}/{fecha}/{marca}/{tipo}/{costo}/{texto}/', 'UserController@transaction');

Route::middleware(['auth'])->group(function(){
	Route::get('/', 'UserController@index');
	Route::match(['get','post'],'/register', 'UserController@register');
	Route::get('/logout', 'UserController@logout');
	Route::post('/question', 'UserController@question');
});

Route::middleware(['guest'])->group(function () {
	Route::match(['get','post'],'login', 'UserController@login');
});
