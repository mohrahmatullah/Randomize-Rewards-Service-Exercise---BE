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

Route::get('/', 'ServiceController@index')->name('service');
Route::post('/', 'ServiceController@post');
Route::post('delete/{id}', 'ServiceController@delete')->name('delete');
Route::post('edit/{id}',  'ServiceController@update')->name('edit');