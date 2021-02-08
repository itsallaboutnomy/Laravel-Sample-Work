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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::get('truncate','\App\Http\Controllers\DatabaseController@index');
Route::group(['prefix' => 'devices'], function () {
    Route::post('/register','\App\Http\Controllers\MobileApplicationSubscriptionController@register');

});
Route::group(['prefix' => 'apps'], function () {
    Route::get('/purchase','\App\Http\Controllers\MobileApplicationSubscriptionController@purchase');
    Route::get('/subscription','\App\Http\Controllers\MobileApplicationSubscriptionController@checkSubscription');
});

Route::group(['prefix'=>'mock'], function(){
   Route::get('/google', '\App\Http\Controllers\PlatformController@google');
   Route::get('/ios', '\App\Http\Controllers\PlatformController@ios');
   Route::get('/verify-subs-ios', '\App\Http\Controllers\PlatformController@verifySubscriptionIos');
   Route::get('/verify-subs-google', '\App\Http\Controllers\PlatformController@verifySubscriptionGoogle');
   Route::post('/third-party-endpoint','\App\Http\Controllers\PlatformController@thirdPartyEndpoint');
});

Route::group(['prefix' => 'reports'], function () {
    Route::get('/', '\App\Http\Controllers\ReportController@index');
});

