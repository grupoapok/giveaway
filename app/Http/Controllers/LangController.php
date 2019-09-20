<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Task;
use Illuminate\Http\Request;

class LangController extends Controller {
    use ProcessTokenTrait;

    function index($step, Request $request) {
        return  __($step);
    }

    function task(Task $task) {
        $arr = [];
        $arr[$task->type]  = __("tasks.".$task->type, ["tickets" => $task->tickets]);
        return $arr;
    }
}
