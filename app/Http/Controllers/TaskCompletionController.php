<?php

namespace App\Http\Controllers;

use App\Events\TaskCompletedEvent;
use App\Http\Resources\SubscriberResource;
use App\Task;
use App\TaskCompletion;
use App\Ticket;
use Illuminate\Http\Request;

class TaskCompletionController extends Controller {
    use ProcessTokenTrait;

    public function store(Task $task, Request $request) {
        $user = $this->getUser($request);

        $taskCompletion = TaskCompletion::create([
            "subscriber_id" => $user->id,
            "task_id" => $task->id
        ]);

        for ($i = 0; $i < $task->tickets; $i++) {
            Ticket::create(["subscriber_id" => $user->id]);
        }

        return new SubscriberResource($user->load("tickets"));
    }
}
