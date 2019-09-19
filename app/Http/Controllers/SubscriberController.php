<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Http\Resources\TaskResource;
use App\Mail\NewSubscriber;
use App\Subscriber;
use App\Task;
use App\TaskCompletion;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriberController extends Controller {
    use ProcessTokenTrait;

    public function index(Request $request) {
        $user = $this->getUser($request);
        if (!is_null($user)) {
            return new SubscriberResource($user->load("tickets"));
        }
        return response("", 401);
    }

    public function store(CreateSubscriberRequest $request) {
        $existingUser = Subscriber::where("email", $request->input("email"))->first();
        if (is_null($existingUser)) {
            $ipinfo = $request->ipinfo;

            $newSubscriber = Subscriber::make($request->all());
            $newSubscriber->city = $ipinfo->city;
            $newSubscriber->country = $ipinfo->country_name;
            $newSubscriber->region = $ipinfo->region;
            $newSubscriber->ipinfo = json_encode($ipinfo);
            $newSubscriber->token = Str::uuid();
            $newSubscriber->save();

            Ticket::create(["subscriber_id" => $newSubscriber->id]);

            Mail::to($newSubscriber->email)
                ->send(
                    new NewSubscriber($newSubscriber->token)
                );

            return new SubscriberResource($newSubscriber->load("tickets"));
        } else {
            return new SubscriberResource($existingUser);
        }
    }

    public function myTasks(Request $request) {
        $user = $this->getUser($request);
        $tasks = Task::all();
        if (!is_null($user)) {
            $completedTasks = TaskCompletion::where("subscriber_id", $user->id)->distinct("task_id")->pluck("task_id")->toArray();
            foreach($tasks as $t) {
                $t->completed = in_array($t->id, $completedTasks);
            }
        }
        return new TaskResource($tasks);
    }

    public function existingSubscriber($encrypted_token) {
        $token = Crypt::decryptString($encrypted_token);
        $user = Subscriber::where("token", $token)->first();
        if (!is_null($user)){
            return redirect("/")->withCookie(Cookie::make("token", $token, 0, '/', null, null, false, false));
        }
        return redirect("/");
    }
}
