<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function (Request $request) {
    $url = str_replace(["https://", "http://"], ["", ""], $request->root());

    if (Str::startsWith($url, "concurso")) {
        App::setLocale("es");
    }
    if (Str::startsWith($url, "giveaway")) {
        App::setLocale("en");
    }

    return view('welcome');
});

Route::get('/subscriber/{encrypted_token}', "SubscriberController@existingSubscriber")->name("returning_user");

Route::get('/auth/callback/linkedin', "OAuth\LinkedInController@auth")->name("linkedin.callback");
Route::get('/auth/callback/twitter', "OAuth\TwitterController@auth")->name("twitter.callback");
