<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class LinkedInController {
    var $authClient;
    var $apiClient;
    var $auth;

    public function __construct() {
        $this->auth = Cookie::get("linkedin_token");
        if ($this->auth) {
            $this->auth = Crypt::decryptString($this->auth);
        }
        $this->authClient = new Client([
            "base_uri" => "https://www.linkedin.com/oauth/v2/"
        ]);
        $this->apiClient = new Client([
            "base_uri" => "https://api.linkedin.com/v2/",
            "headers" => [
                "X-Restli-Protocol-Version" => "2.0.0",
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $this->auth,
            ]
        ]);
    }

    function auth(Request $request) {
        if ($request->has("code") && !$request->has("error")) {
            $response = $this->authClient->post("accessToken", [
                "form_params" => [
                    "grant_type" => "authorization_code",
                    "redirect_uri" => env("APP_URL") . "/auth/callback/linkedin",
                    "client_id" => env("LINKED_IN_API_KEY"),
                    "client_secret" => env("LINKED_IN_API_SECRET"),
                    "code" => $request->input("code")
                ]
            ]);

            $json = json_decode($response->getBody());
            $token = $json->access_token;

            return redirect("/")->withCookies([
                Cookie::make("linkedin_token", $token, 0, '/', null, null, false, false),
                Cookie::make("execute_task", "linkedin", 0, '/', null, null, false, false),
            ]);
        }
        return redirect("/");
    }

    function share() {
        $author = "urn:li:person:" ;
        try {
            $response = $this->apiClient->get("me");
            $json = json_decode($response->getBody(), true);
            $author .= $json["id"];
        }catch(ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401){
                return response([
                    "goto" => "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".env("LINKED_IN_API_KEY")."&redirect_uri=".env("APP_URL")."/auth/callback/linkedin&scope=r_liteprofile%20r_emailaddress%20w_member_social"
                ], 401);
            }
        }

        try {
            list ($uploadUrl, $asset) = $this->registerImage($author);

            $this->apiClient->post($uploadUrl, [
                "headers" => [
                    "Content-Type" => "application/octect-stream"
                ],
                "body" => file_get_contents(storage_path(ENV('SHARE_IMG')))
            ]);

            $response = $this->apiClient->post("ugcPosts", [
                "json" => [
                    "author" => $author,
                    "lifecycleState" => "PUBLISHED",
                    "visibility" => [
                        "com.linkedin.ugc.MemberNetworkVisibility" => "CONNECTIONS"
                    ],
                    "specificContent" => [
                        "com.linkedin.ugc.ShareContent" => [
                            "shareCommentary" => [
                                "text" => "Test http://www.grupoapok.com",
                            ],
                            "shareMediaCategory" => "IMAGE",
                            "media" => [
                                [
                                    "status" => "READY",
                                    "description" => [
                                        "text" => "Concurso"
                                    ],
                                    "media" => $asset,
                                    "title" => [
                                        "text" => "Concurso Apok"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
            if ($response->getStatusCode() == 201) {
                return response(["OK"], $response->getStatusCode());
            } else {
                return response(["ERROR"], $response->getStatusCode());
            }
        } catch (ClientException $e) {
            echo $e->getMessage();
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();

            return response()->json([
                "response" => $responseBody
            ], 400);
        }
    }

    private function registerImage($author) {
        $json = [
            "registerUploadRequest" => [
                "recipes" => [
                    "urn:li:digitalmediaRecipe:feedshare-image"
                ],
                "owner" => $author,
                "serviceRelationships" => [
                    [
                        "relationshipType" => "OWNER",
                        "identifier" => "urn:li:userGeneratedContent"
                    ]
                ]
            ]
        ];
        $query = ["action" => "registerUpload"];

        $response = $this->apiClient->post("assets", compact("query","json"));
        $json = json_decode($response->getBody()->getContents(), true);
        return [
            $json["value"]["uploadMechanism"]["com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest"]["uploadUrl"],
            $json["value"]["asset"]
        ];
    }
}