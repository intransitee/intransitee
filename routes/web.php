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
Route::get('/logout', 'AuthController@logout')->name('logout');

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
    Route::get('/exportOrder', 'OrderController@export')->name('exportOrder');
    Route::post('/importOrder', 'OrderController@import')->name('importOrder');
    Route::get('/getDetail', 'OrderController@getDetail')->name('getDetail');
    Route::get('/detail/{id}', 'OrderController@detail')->name('detail');
    Route::post('/insert', 'OrderController@insert')->name('insert');
    Route::post('/delete', 'OrderController@delete')->name('delete');
    Route::post('/updateStatus', 'OrderController@updateStatus')->name('updateStatus');
});

// Manage User
Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
    Route::get('/daftar-user', 'UserController@index')->name('user');
    Route::get('/get-user', 'UserController@getUser')->name('getUser');
    Route::get('/add', 'UserController@add')->name('add');
    Route::get('/detail/{id}', 'UserController@detail')->name('detail');
    Route::get('/getDetail', 'UserController@getDetail')->name('getDetail');
    Route::post('/insert', 'UserController@insert')->name('insert');
    Route::post('/update', 'UserController@update')->name('update');
    Route::post('/delete', 'UserController@delete')->name('delete');
});

// Manage Role
Route::group(['prefix' => 'roles', 'as' => 'role.'], function () {
    Route::get('/daftar-role', 'RoleController@index')->name('role');
    Route::get('/get-role', 'RoleController@getRole')->name('getRole');
    Route::get('/add', 'RoleController@add')->name('add');
    Route::get('/detail/{id}', 'RoleController@detail')->name('detail');
    Route::post('/insert', 'RoleController@insert')->name('insert');
    Route::get('/getDetail', 'RoleController@getDetail')->name('getDetail');
    Route::post('/update', 'RoleController@update')->name('update');
    Route::post('/delete', 'RoleController@delete')->name('delete');
});

// Manage Menu Access
Route::group(['prefix' => 'menus', 'as' => 'menu.'], function () {
    Route::get('/daftar-menu/{id}', 'MenuController@index')->name('menu');
    Route::get('/get-menu', 'MenuController@getMenu')->name('getMenu');
    Route::get('/add/{id_role}', 'MenuController@add')->name('add');
    Route::get('/detail/{id_menu}/{id_role}', 'MenuController@detail')->name('detail');
    Route::post('/insert', 'MenuController@insert')->name('insert');
    Route::get('/getDetail', 'MenuController@getDetail')->name('getDetail');
    Route::post('/update', 'MenuController@update')->name('update');
    Route::post('/delete', 'MenuController@delete')->name('delete');
});


// Reff
Route::get('/reffClient', 'OrderController@reffClient')->name('reffClient');
Route::get('/reffService', 'OrderController@reffService')->name('reffService');
Route::get('/reffZipcode', 'OrderController@reffZipcode')->name('reffZipcode');
Route::get('/getArea', 'OrderController@getArea')->name('getArea');
Route::get('/getDistrict', 'OrderController@getDistrict')->name('getDistrict');
Route::get('/getStatus', 'OrderController@getStatus')->name('getStatus');
Route::get('/getType', 'OrderController@getType')->name('getType');
Route::get('/reffClientCategory', 'ClientController@reffClientCategory')->name('reffClientCategory');
Route::get('/reffRoles', 'UserController@reffRoles')->name('reffRoles');
Route::get('/reffMenuFunction', 'MenuController@reffMenuFunction')->name('reffMenuFunction');
Route::post('/updateLogBulk', 'OrderController@updateLogBulk')->name('updateLogBulk');
