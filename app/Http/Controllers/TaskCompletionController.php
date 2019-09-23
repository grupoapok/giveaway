<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Http\Resources\SubscriberResource;
use App\Mail\TaskCompleted;
use App\Subscriber;
use App\Task;
use App\TaskCompletion;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class TaskCompletionController extends Controller {
    use ProcessTokenTrait;

    public function store(Task $task, Request $request) {
        $user = $this->getUser($request);

        if (!is_null($user)) {
            $this->completeTask($user, $task, $request);

            return new SubscriberResource($user);
        }
        return response("", 404);
    }

    public function fromWebhook(Task $task, Request $request) {
        $email = $request->input("email");
        $user = Subscriber::where("email", $email)->first();

        if (!is_null($user)) {
            $this->completeTask($user, $task, $request);

            return new SubscriberResource($user);
        }
        return response("", 404);
    }

    private function completeTask(Subscriber $user, Task $task, Request $request) {
        $tc = TaskCompletion::create([
            "subscriber_id" => $user->id,
            "task_id" => $task->id
        ]);

        for ($i = 0; $i < $task->tickets; $i++) {
            Ticket::create([
                "subscriber_id" => $user->id,
                "task_completions_id" => $tc->id
            ]);
        }

        $user->load("tickets");

        Mail::to($user->email)
            ->send(
                new TaskCompleted(
                    $task,
                    count($user->tickets),
                    Cookie::get("lang")
                )
            );
    }
}
