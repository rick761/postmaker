<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/', 'UserController@profile');
    Route::post('/update', 'UserController@updateProfile');
    Route::post('/image/delete', 'UserController@deleteUserImage');  
    Route::post('/delivery/show', 'UserController@setShowFiles');     
    Route::post('/delivery/hide', 'UserController@hideShowFiles');     
});

Route::prefix('notifications')->group(function () {        
    Route::get('get', 'NotificationController@get'); 
    Route::post('read', 'NotificationController@read'); 
    Route::post('remove', 'NotificationController@remove'); 
});    

Route::get('/user/{id}','UserController@get');
Route::post('/file/upload/{type}/{folder}', 'FileController@upload');
Route::get('/home', 'HomeController@index')->name('home');

//order
Route::prefix('order')->group(function () {
    Route::get('get/{id}','OrderController@get');
    Route::post('create', 'OrderController@create')->middleware('type:requester');
    Route::post('update','OrderController@update');
    Route::get('connect/postmaker/{orderId}','OrderController@connectPostmaker');
    Route::get('like/{orderId}','OrderController@like');
   
    Route::post('tags/save','Order\TagController@save')->middleware('type:requester');   
    Route::post('descriptions/save','Order\DescriptionController@save')->middleware('type:requester');
    Route::post('message/send','Order\MessageController@send');

    Route::prefix('request')->group(function () {
        Route::post('put','Order\RequestController@put')->middleware('type:postmaker');
        Route::post('withrawn','Order\RequestController@withrawn')->middleware('type:postmaker');
        Route::post('deny','Order\RequestController@deny')->middleware('type:requester');
        Route::post('accept','Order\RequestController@accept')->middleware('type:requester');
        Route::post('withrawAll','Order\RequestController@withrawAll')->middleware('type:requester');
    });
    
    Route::prefix('files')->group(function () {
        Route::post('save','Order\FilesController@save')->middleware('type:requester');
        Route::get('delete/{orderFileId}','Order\FilesController@delete')->middleware('type:requester');
    });

   
    Route::prefix('delivery')->group(function () {
        Route::post('create','Order\DeliveryController@create')->middleware('type:postmaker');
        Route::post('rate','Order\DeliveryController@rate')->middleware('type:requester');
        
        Route::post('final_create','Order\DeliveryController@final_create')->middleware('type:postmaker');

        Route::prefix('comments')->group(function () {            
            Route::get('get/{deliveryId}','Order\DeliveryCommentController@get');
            Route::post('create','Order\DeliveryCommentController@create');
        });
    });
});

Route::prefix('orders')->group(function () {
    Route::get('get','OrdersController@get');
    Route::get('available','OrdersController@available');
    Route::get('requested','OrdersController@requested');
    Route::get('archived','OrdersController@archived');
    Route::get('archived/successfull', 'OrdersController@archivedSuccess');
});


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

Route::post('/send/feedback','FeedbackController@create');
Route::get('/get/feedback','FeedbackController@get')->middleware('type:admin');