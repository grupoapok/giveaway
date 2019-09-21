<?php

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Thujohn\Twitter\Facades\Twitter;

class TwitterController extends OauthTaskController {

    function getCookieName() {
        return "twitter_token";
    }

    function isValidAuthToken() {
        Twitter::reconfig([
            $this->getAuthToken(),
            Crypt::decryptString(Cookie::get("twitter_token_secret"))
        ]);
        try {
            Twitter::getCredentials();
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    function sendContent() {
        try {
            Twitter::reconfig([
                $this->getAuthToken(),
                Crypt::decryptString(Cookie::get("twitter_token_secret"))
            ]);

            $content = [
                'status' => 'Laravel is beautiful',
            ];

            if (config('giveaway.share_img')) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get(storage_path(config('giveaway.share_img')))]);
                $content['media_ids'] = $uploaded_media->media_id_string;
            }

            if (config("ttwitter.TWITTER_FOLLOW_US_ID")) {
                Twitter::postFollow([
                    "screen_name" => config("ttwitter.TWITTER_FOLLOW_US_ID")
                ]);
            }

            Twitter::postTweet($content);

            return response("OK", 200);
        }catch (\Exception $e){
            return response($e->getMessage(), 400);
        }
    }

    function getURLForOauth() {
        try {
            Twitter::reconfig(["token" => "", "secret" => ""]);
            $token = Twitter::getRequestToken(route("twitter.callback"));

            if (isset($token['oauth_token_secret'])) {
                $url = Twitter::getAuthorizeURL($token, true, false);

                $response = response()->json(["url" => $url], 401);
                $response->headers->setCookie(Cookie::make("tw_oauth_request_token", $token["oauth_token"],0,'/',null,null,false,false));
                $response->headers->setCookie(Cookie::make("tw_oauth_request_token_secret", $token["oauth_token_secret"],0,'/',null,null,false,false));

                return $response;
            }
            return response("error", 400);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    function auth(Request $request) {
        $token = $_COOKIE['tw_oauth_request_token'];
        $token_secret = $_COOKIE['tw_oauth_request_token_secret'];

        if ($token) {
            $request_token = [
                'token' => $token,
                'secret' => $token_secret,
            ];

            Twitter::reconfig($request_token);

            if (Input::has('oauth_verifier')) {
                $oauth_verifier = Input::get('oauth_verifier');
                // getAccessToken() will reset the token for you
                $token = Twitter::getAccessToken($oauth_verifier);
            }

            if (!isset($token['oauth_token_secret'])) {
                return redirect('/');
            }

            return Redirect::to('/')->withCookies([
                Cookie::forget("tw_oauth_request_token"),
                Cookie::forget("tw_oauth_request_token_secret"),
                Cookie::make("twitter_token", $token["oauth_token"], 0, '/', null, null, false, false),
                Cookie::make("twitter_token_secret", $token["oauth_token_secret"], 0, '/', null, null, false, false),
                Cookie::make("execute_task", "twitter", 0, '/', null, null, false, false),
            ]);
        } else {
            return redirect('/');
        }
    }
}
