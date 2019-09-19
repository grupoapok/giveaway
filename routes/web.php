<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscriber/{encrypted_token}', "SubscriberController@existingSubscriber")->name("returning_user");

Route::get('/auth/callback/linkedin', "OAuth\LinkedInController@auth")->name("linkedin.callback");
Route::get('/auth/callback/twitter', "OAuth\TwitterController@auth")->name("twitter.callback");
