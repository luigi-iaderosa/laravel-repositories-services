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

Route::get('/', 'ArticleController@all');
Route::get('article/{id}','ArticleController@show');
Route::get('purchase/{id}','ArticleController@purchase')->middleware(['auth']);
Route::get('login','LoginController@login')->name('login');
