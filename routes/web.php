<?php

use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    return view('welcome');
});

Route::get('/auth/callback/linkedin', "LinkedInController@auth");
Route::get('/auth/callback/twitter', "TwitterController@auth")->name("twitter.callback");