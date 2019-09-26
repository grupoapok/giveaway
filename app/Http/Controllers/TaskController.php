<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index(Request $request) {
        return TaskResource::collection(Task::paginate());
    }

    public function store(Request $request) {
        $task = Task::create($request->all());
        return new TaskResource($task);
    }

    public function show(Task $task) {
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task) {
        $task->update($request->all());
        $task->save();
        return new TaskResource($task);
    }

    public function destroy(Task $task) {
        $task->delete();
        return response()->noContent();
    }
}
