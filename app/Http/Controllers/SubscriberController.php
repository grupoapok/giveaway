<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TicketResource;
use App\Mail\NewSubscriber;
use App\Subscriber;
use App\Task;
use App\TaskCompletion;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Newsletter;

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
        $subscriber = Subscriber::where("email", $request->input("email"))->first();
        Log::error($request->input('grecaptcha'));

        if (is_null($subscriber)) {

            $ipinfo = $request->ipinfo;

            $newSubscriber = Subscriber::make($request->all());
            if ($ipinfo) {
                if ($ipinfo->city) {
                    $newSubscriber->city = $ipinfo->city;
                }
                if ($ipinfo->country) {
                    $newSubscriber->country = $ipinfo->country_name;
                }
                if ($ipinfo->region) {
                    $newSubscriber->region = $ipinfo->region;
                }
                $newSubscriber->ipinfo = json_encode($ipinfo);
            }

            $newSubscriber->token = Str::uuid();
            $newSubscriber->save();

          Newsletter::subscribe($newSubscriber->email,[
                'FNAME' => explode(' ',$newSubscriber->name,2)[0],
                'LNAME'  => explode(' ',$newSubscriber->name,2)[1]
            ]);
            Log::debug( print_r(Newsletter::getLastError(),true));

            Ticket::create([
                "subscriber_id" => $newSubscriber->id
            ]);

            Mail::to($newSubscriber->email)
                ->send(
                    new NewSubscriber($newSubscriber->token, $newSubscriber->name)
                );

            $subscriber = $newSubscriber;
        }
        return new SubscriberResource($subscriber->load("tickets"));
    }

    public function myTasks(Request $request) {
        $user = $this->getUser($request);
        $tasks = Task::orderBy("order","asc")->get();
        if (!is_null($user)) {
            $completedTasks = TaskCompletion::bySubscriber($user->id)->completed()->distinct("task_id")->pluck("task_id")->toArray();
            $incompleteManualTasks = TaskCompletion::bySubscriber($user->id)->incomplete()->manual()->distinct("task_id")->pluck("task_id")->toArray();
            foreach($tasks as $t) {
                $t->completed = in_array($t->id, $completedTasks) || in_array($t->id, $incompleteManualTasks);
                $completion = TaskCompletion::bySubscriber($user->id)->byTask($t->id)->first();
                $t->status = is_object($completion)? __('tasks.'.$completion->status): null;

            }

        }
        return TaskResource::collection($tasks);
    }

    public function existingSubscriber($encrypted_token) {
        $token = Crypt::decryptString($encrypted_token);
        $user = Subscriber::where("token", $token)->first();
        if (!is_null($user)){
            return redirect("/")->withCookie(Cookie::make("token", $token, 0, '/', null, null, false, false));
        }
        return redirect("/");
    }

    public function myTickets(Request $request){
        $user = $this->getUser($request);

        return TicketResource::collection($user->tickets);
    }
}
