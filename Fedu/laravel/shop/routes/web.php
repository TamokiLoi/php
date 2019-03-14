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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/users', 'UserController@index')->name('user.index');
    Route::get('/users/create', 'UserController@create')->name('user.create');
    Route::post('/users/store', 'UserController@store')->name('user.store');
    Route::get('/users/{id}/show', 'UserController@show')->where(['id' => '[0-9]+'])->name('user.show');
    Route::put('/users/{id}/update', 'UserController@update')->name('user.update');
    Route::delete('/users/{id}/delete', 'UserController@delete')->name('user.delete');
});

Route::get('/home', 'HomeController@index')->name('home');

