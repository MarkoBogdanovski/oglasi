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

Route::get('/', 'HomeController@index');

Route::get('ads','TopicsController@create');
Route::post('topic','TopicsController@store');
Route::get('edit/{id}','TopicsController@edit');
Route::post('edit/{id}','TopicsController@update');
Route::delete('{id}','TopicsController@destroy');

