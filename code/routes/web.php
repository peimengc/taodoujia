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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home2', 'HomeController@index2')->name('home2');

Route::get('/ordertest',function () {
    set_time_limit(3600);
    $orderHelper = new \App\Helpers\Tbk\TbkOrderHelper();
    $tbkAuth = \App\Models\TbkAuthorize::query()->first();
    if ($tbkAuth){
       $orderHelper->getHistoryOrder($tbkAuth->access_token,'2019-11-01');
    }
});

Route::get('/tasktest',function () {
    set_time_limit(3600);
    $taskHelper = new \App\Helpers\Dou\DouTopTaskGetHelper();
    $endTime = \App\Models\DouTopTask::getNewTaskCreateTime();
    $taskHelper->getNewTask($endTime);
});

Route::get('costtest',function () {
    set_time_limit(3600);
    $tasks = \App\Models\DouTopTask::getAllByCostIsNull();
    $helper = new \App\Helpers\Dou\DouTopTaskInfoGetHelper($tasks);
    $helper->execute();
});

Route::get('producttest',function () {
    set_time_limit(3600);
    $tasks = \App\Models\DouTopTask::getAwemeIdsByProductIdIsNull();
    $helper = new \App\Helpers\Dou\DouTopTaskProductIdGetHelper($tasks);
    $helper->execute();
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/tbkOrders', 'TbkOrderController@index')->name('tbkOrders.index');

    Route::get('/douTopTasks', 'DouTopTaskController@index')->name('douTopTasks.index');

    Route::get('/tbkAuthorizes', 'TbkAuthorizeController@index')->name('tbkAuthorizes.index');
    Route::get('/tbkAuthorizes/create', 'TbkAuthorizeController@create')->name('tbkAuthorizes.create');
    Route::post('/tbkAuthorizes', 'TbkAuthorizeController@store')->name('tbkAuthorizes.store');

    Route::resource('/douAccounts','DouAccountController');
});
