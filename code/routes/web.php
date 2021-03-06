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

Auth::routes(['register' => false]);

Route::group([
    'middleware' => 'auth'
], function () {

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/tbkOrders', 'TbkOrderController@index')->name('tbkOrders.index');
    Route::get('/tbkOrders/history', 'TbkOrderController@getHistory')->name('tbkOrders.history');

    Route::get('/douTopTasks', 'DouTopTaskController@index')->name('douTopTasks.index');

    Route::get('/tbkAuthorizes', 'TbkAuthorizeController@index')->name('tbkAuthorizes.index');
    Route::get('/tbkAuthorizes/create', 'TbkAuthorizeController@create')->name('tbkAuthorizes.create');
    Route::post('/tbkAuthorizes', 'TbkAuthorizeController@store')->name('tbkAuthorizes.store');

    Route::resource('/douAccounts','DouAccountController');

    Route::get('/taodoujia/hour','DouJiaTongJiController@hour')->name('taodoujia.hour');
    Route::get('/taodoujia/douAccount','DouJiaTongJiController@douAccount')->name('taodoujia.douAccount');
});
