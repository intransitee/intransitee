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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/login', 'AuthController@index')->name('login');

// Auth
Route::post('/checkAuth', 'AuthController@checkAuth')->name('checkAuth');

// Clients
Route::group(['prefix' => 'clients', 'as' => 'client.'], function () {
    Route::get('/daftar-client', 'ClientController@index')->name('client');
    Route::get('/get-client', 'ClientController@getClient')->name('getClient');
    Route::get('/add', 'ClientController@add')->name('add');
    Route::get('/edit', 'ClientController@edit')->name('edit');
    Route::get('/detail-client', 'ClientController@detailClient')->name('detailClient');
    Route::post('/insert', 'ClientController@insert')->name('insert');
    Route::post('/update', 'ClientController@update')->name('update');
    Route::post('/delete', 'ClientController@delete')->name('delete');
});

// Order
Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
    Route::get('/daftar-order', 'OrderController@index')->name('order');
    Route::get('/get-order', 'OrderController@getOrder')->name('getOrder');
    Route::get('/add', 'OrderController@add')->name('add');
    Route::get('/getDetail', 'OrderController@getDetail')->name('getDetail');
    Route::get('/detail/{id}', 'OrderController@detail')->name('detail');
    Route::post('/insert', 'OrderController@insert')->name('insert');
    Route::post('/delete', 'OrderController@delete')->name('delete');
    Route::post('/updateStatus', 'OrderController@updateStatus')->name('updateStatus');
});

Route::get('/reffClient', 'OrderController@reffClient')->name('reffClient');
Route::get('/reffService', 'OrderController@reffService')->name('reffService');
Route::get('/reffZipcode', 'OrderController@reffZipcode')->name('reffZipcode');
Route::get('/getArea', 'OrderController@getArea')->name('getArea');
Route::get('/getDistrict', 'OrderController@getDistrict')->name('getDistrict');
Route::get('/getStatus', 'OrderController@getStatus')->name('getStatus');
Route::get('/getType', 'OrderController@getType')->name('getType');
Route::get('/reffClientCategory', 'ClientController@reffClientCategory')->name('reffClientCategory');
