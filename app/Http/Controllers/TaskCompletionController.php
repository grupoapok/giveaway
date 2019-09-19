<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Http\Resources\SubscriberResource;
use App\Mail\TaskCompleted;
use App\Task;
use App\TaskCompletion;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskCompletionController extends Controller {
    use ProcessTokenTrait;

    public function store(Task $task, Request $request) {
        $user = $this->getUser($request);

        TaskCompletion::create([
            "subscriber_id" => $user->id,
            "task_id" => $task->id
        ]);

        for ($i = 0; $i < $task->tickets; $i++) {
            Ticket::create(["subscriber_id" => $user->id]);
        }

        $user->load("tickets");

        Mail::to($user->email)
            ->send(
                new TaskCompleted(
                    $task,
                    count($user->tickets),
                    str_replace('_', '-', $request->getLocale())
                )
            );

        return new SubscriberResource($user);
    }
}
