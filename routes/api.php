<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource("/subscribers","SubscriberController")->only(["index","store"]);
Route::resource("/tasks","TaskController")->only("index");

Route::post("/tasks/{task}/complete","TaskCompletionController@store");

Route::post("/share/linkedin", "LinkedInController@share");
Route::post("/share/twitter", "TwitterController@share");

Route::post("/twitter/token","TwitterController@getRequestToken");
Route::post("/twitter/authorize", "TwitterController@authorize");
