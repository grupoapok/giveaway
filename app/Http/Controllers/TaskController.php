<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Task;
use App\TaskCompletion;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ProcessTokenTrait;

    public function index(Request $request){
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
