<?php

namespace App\Http\Controllers\Traits;

use App\Subscriber;
use Illuminate\Http\Request;

trait ProcessTokenTrait {
    function getUser(Request $request) {
        $token = $request->header("Token");
        return Subscriber::where("token", $token)->first();
    }
}