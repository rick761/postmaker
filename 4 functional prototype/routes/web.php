<?php

use Illuminate\Support\Facades\Route;


//auth
Route::get('/auth', 'UserController@profile');
Route::post('/auth/update', 'UserController@updateProfile');
Route::post('/auth/image/delete', 'UserController@deleteUserImage');

//user
Route::get('/user/{id}','UserController@get');

//file
Route::post('/file/upload/{type}/{folder}', 'FileController@upload');

//order
Route::get('/order/get/{id}','OrderController@get');
Route::post('/order/create', 'OrderController@create')->middleware('type:requester');
Route::post('/order/update','OrderController@update');
Route::get('/order/connect/postmaker/{orderId}','OrderController@connectPostmaker');

//order - Descriptions
Route::post('/order/descriptions/save','Order\DescriptionController@save')->middleware('type:requester');

//order - Requests
Route::post('/order/request/put','Order\RequestController@put')->middleware('type:postmaker');
Route::post('/order/request/withrawn','Order\RequestController@withrawn')->middleware('type:postmaker');
Route::post('/order/request/deny','Order\RequestController@deny')->middleware('type:requester');
Route::post('/order/request/accept','Order\RequestController@accept')->middleware('type:requester');
Route::post('/order/request/withrawAll','Order\RequestController@withrawAll')->middleware('type:requester');

//Order - Files
Route::post('/order/files/save','Order\FilesController@save')->middleware('type:requester');
Route::get('/order/files/delete/{orderFileId}','Order\FilesController@delete')->middleware('type:requester');

//Order - Tags
Route::post('/order/tags/save','Order\TagController@save')->middleware('type:requester');


//orders
Route::get('/orders/get','OrdersController@get');
Route::get('/orders/available','OrdersController@available');
Route::get('/orders/requested','OrdersController@requested');

//alternative
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/', function () {
    return view('landing');
});

Route::get('/error',function(){
    return 'Niet toegestaan.';
})->name('error');

//public path
Route::get('/public_path', function () {
    return url('/storage/');
});