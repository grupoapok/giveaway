<?php

namespace App\Http\Controllers\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LinkedInController extends OauthTaskController {
    var $authClient;
    var $apiClient;
    var $authorId;

    public function __construct() {
        $this->authClient = new Client([
            "base_uri" => "https://www.linkedin.com/oauth/v2/"
        ]);
        $this->apiClient = new Client([
            "base_uri" => "https://api.linkedin.com/v2/",
            "headers" => [
                "X-Restli-Protocol-Version" => "2.0.0",
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $this->getAuthToken(),
            ]
        ]);
    }

    function getCookieName() {
        return "linkedin_token";
    }

    function isValidAuthToken() {
        try {
            $response = $this->apiClient->get("me");
            $json = json_decode($response->getBody(), true);
            $this->authorId = "urn:li:person:" . $json["id"];
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function sendContent() {
        try {
            $asset = null;
            if (config('giveaway.share_img_linkedin')) {
                list ($uploadUrl, $asset) = $this->registerImage();

                $this->apiClient->post($uploadUrl, [
                    "headers" => [
                        "Content-Type" => "application/octect-stream"
                    ],
                    "body" => file_get_contents(storage_path(config('giveaway.share_img_linkedin')))
                ]);
            }

            $response = $this->apiClient->post("ugcPosts", [
                "json" => $this->getContentToShare($asset)
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

    function getURLForOauth() {
        return response([
            "url" => "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=" . config('linkedin.client_id') . "&redirect_uri=" . route("linkedin.callback") . "&scope=r_liteprofile%20r_emailaddress%20w_member_social"
        ], 401);
    }

    function auth(Request $request) {
        if ($request->has("code") && !$request->has("error")) {
            $response = $this->authClient->post("accessToken", [
                "form_params" => [
                    "grant_type" => "authorization_code",
                    "redirect_uri" => route("linkedin.callback"),
                    "client_id" => config('linkedin.client_id'),
                    "client_secret" => config('linkedin.client_secret'),
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

    private function getContentToShare($imageAsset = null) {
        $shareMediaCategory = "NONE";
        if (!is_null($imageAsset)) {
            $shareMediaCategory = "IMAGE";
        }
        $json = [
            "author" => $this->authorId,
            "lifecycleState" => "PUBLISHED",
            "visibility" => [
                "com.linkedin.ugc.MemberNetworkVisibility" => "CONNECTIONS"
            ],
            "specificContent" => [
                "com.linkedin.ugc.ShareContent" => [
                    "shareCommentary" => [
                        "text" => __("share.linkedin", [], Cookie::get("lang") ?? app()->getLocale()),
                    ],
                    "shareMediaCategory" => $shareMediaCategory,
                ]
            ]
        ];

        if (!is_null($imageAsset)) {
            $json["specificContent"]["com.linkedin.ugc.ShareContent"]["media"] = [
                [
                    "status" => "READY",
                    "description" => [
                        "text" => "Concurso"
                    ],
                    "media" => $imageAsset,
                    "title" => [
                        "text" => "Concurso Apok"
                    ]
                ]
            ];
        }

        return $json;
    }

    private function registerImage() {
        $json = [
            "registerUploadRequest" => [
                "recipes" => [
                    "urn:li:digitalmediaRecipe:feedshare-image"
                ],
                "owner" => $this->authorId,
                "serviceRelationships" => [
                    [
                        "relationshipType" => "OWNER",
                        "identifier" => "urn:li:userGeneratedContent"
                    ]
                ]
            ]
        ];
        $query = ["action" => "registerUpload"];

        $response = $this->apiClient->post("assets", compact("query", "json"));
        $json = json_decode($response->getBody()->getContents(), true);
        return [
            $json["value"]["uploadMechanism"]["com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest"]["uploadUrl"],
            $json["value"]["asset"]
        ];
    }
}
