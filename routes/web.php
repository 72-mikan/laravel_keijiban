<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//ログインページ
Route::get('layouts/login', 'App\Http\Controllers\LayoutsController@login');
Route::post('layouts/login', 'App\Http\Controllers\LayoutsController@comfirm');
//登録ページ
Route::get('layouts/touroku', 'App\Http\Controllers\LayoutsController@touroku');
Route::post('layouts/register', 'App\Http\Controllers\LayoutsController@register');
//完了ページ
Route::get('layouts/complete/{user_id}', 'App\Http\Controllers\LayoutsController@complete');

//フォーム部分
Route::get('keijiban/form', 'App\Http\Controllers\PostController@form');
//Route::post('keijiban/form', 'App\Http\Controllers\PostController@form');
//Route::get('keijiban/post', 'App\Http\Controllers\PostController@post');
Route::post('keijiban/post', 'App\Http\Controllers\PostController@post');

//編集部分
Route::get('save/{id}/edit', 'App\Http\Controllers\SaveController@edit');
Route::patch('save/{id}', 'App\Http\Controllers\SaveController@update');

//削除部分
Route::get('save/{id}', 'App\Http\Controllers\SaveController@show');
Route::delete('save/{id}', 'App\Http\Controllers\SaveController@delete');
