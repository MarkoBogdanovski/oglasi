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


Route::get('/', function() {
	return redirect('/home');
});

Route::get('home', 'HomeController@index')->name('home');
Route::get('{id}/{name}', 'HomeController@show')->where(['id' => '[0-9]+']);

Auth::routes(['register' => false]);

Route::get('ads','AdsController@index');
Route::get('ad','AdsController@create');
Route::post('ad','AdsController@store');
Route::delete('ad','AdsController@destroy');

Route::get('categories','CategoryController@index');
Route::get('category','CategoryController@create')->name('category');
Route::post('category','CategoryController@store');
