<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->has("lang")){
        app()->setLocale($request->input("lang") ?? "es");
        Cookie::queue(
            Cookie::make("lang", $request->input("lang"),0,'/',null,null,false,false)
        );
    } else {
        Cookie::queue(
            Cookie::make("lang", app()->getLocale(), 0,'/',null,null,false,false)
        );
    }
    return view('welcome');
});

Route::get('/subscriber/{encrypted_token}', "SubscriberController@existingSubscriber")->name("returning_user");

Route::get('/auth/callback/linkedin', "OAuth\LinkedInController@auth")->name("linkedin.callback");
Route::get('/auth/callback/twitter', "OAuth\TwitterController@auth")->name("twitter.callback");

Route::get('/privacy', function () {
    return view('legal.privacy');
});

Route::get('/terms-and-conditions', function () {
    return view('legal.conditions');
});
