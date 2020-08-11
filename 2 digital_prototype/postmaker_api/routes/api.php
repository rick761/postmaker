<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::get('user/{id}',['uses'=>'UserController@profile']);

Route::get('/public_path', function () {
    return url('/storage/');
});


Route::middleware(['auth:api'])->group(function () { // with auth login
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });    

    Route::post('updateUser', 'UserController@updateUserField');
    Route::get('logout', 'ApiController@logout');

    Route::prefix('notifications')->group(function () {        
        Route::get('get', 'NotificationController@get'); 
        Route::post('read', 'NotificationController@read'); 
    });    

    Route::prefix('orders')->group(function () {
        Route::get('open', 'OrderController@open'); 
        Route::get('postmaker', 'OrderController@postmaker');
        Route::get('contentaanvrager', 'OrderController@contentaanvrager'); 
        Route::get('requested', 'OrderController@requested');     
        Route::get('archived', 'OrderController@archived');        
    });

    Route::prefix('order')->group(function () {
        Route::get('view/{id}', ['uses'=>'OrderController@view'] );
        Route::post('save', 'OrderController@save' );
        Route::post('setState', 'OrderController@state' );
        Route::post('setPostmakerState', 'OrderController@postmakerState' );
        Route::get('create', 'OrderController@create' );

        Route::prefix('image')->group(function () {
            Route::post('upload', 'ImageController@upload' );
            Route::post('delete', 'ImageController@delete' );                    
        });

        Route::prefix('delivery')->group(function () {
            Route::post('upload', 'DeliveryController@upload' );
        });

        Route::prefix('comment')->group(function () {
            Route::post('new', 'CommentController@new' );
            Route::post('delete', 'CommentController@delete' );
            Route::post('update', 'CommentController@update' );
        });

        Route::prefix('message')->group(function () {
            Route::post('new', 'MessageController@new' );            
        });

        Route::prefix('request')->group(function () {
            Route::post('put', 'RequestController@put' );            
            Route::post('accept', 'RequestController@accept' );   
            Route::post('decline', 'RequestController@decline' ); 
            Route::post('delete', 'RequestController@delete' ); 
        });
        
     });
});


