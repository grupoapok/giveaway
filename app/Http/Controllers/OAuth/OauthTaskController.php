<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

abstract class OauthTaskController extends Controller {
    var $authToken;

    function hasAuth(){
        $cookie = Cookie::get($this->getCookieName());
        return !is_null($cookie) && trim($cookie) != "";
    }

    function getAuthToken(){
        if ($this->hasAuth() && is_null($this->authToken)) {
            $this->authToken = Crypt::decryptString(Cookie::get($this->getCookieName()));
        }
        return $this->authToken;
    }

    function share() {
        if ($this->hasAuth() && $this->isValidAuthToken()) {
            return $this->sendContent();
        }
        return $this->getURLForOauth();
    }

    abstract function getCookieName();

    abstract function isValidAuthToken();

    abstract function sendContent();

    abstract function getURLForOauth();

    abstract function auth(Request $request);
}