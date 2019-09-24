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

Route::get('/social_info', function () {
    return array_map(
        function ($e) {
            list ($name, $url) = explode("|", $e);
            return compact("name", "url");
        },
        explode(",", config('giveaway.social_networks'))
    );
});

Route::resource("/subscribers", "SubscriberController")->only(["index", "store"]);
Route::get("/subscribers/tasks", "SubscriberController@myTasks");
Route::get("/subscribers/tickets", "SubscriberController@myTickets");

Route::post("/tasks/{task}/complete", "TaskCompletionController@store");
Route::post("/tasks/{task}/webhook", "TaskCompletionController@fromWebhook");

Route::post("/share/linkedin", "OAuth\LinkedInController@share");
Route::post("/share/twitter", "OAuth\TwitterController@share");

Route::get("/lang/{step}", "LangController@index");
Route::get("/lang/task/{task}", "LangController@task");


Route::apiResource('/tasks', 'TaskController');
