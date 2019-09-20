<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Task;
use Illuminate\Http\Request;

class LangController extends Controller {
    use ProcessTokenTrait;

    function index($step, Request $request) {
        return  __($step, [], app()->getLocale());
    }

    function task(Task $task, Request $request) {
        $arr = [];
        $arr[$task->type]  = __("tasks.".$task->type, ["tickets" => $task->tickets], app()->getLocale());
        return $arr;
    }
}
