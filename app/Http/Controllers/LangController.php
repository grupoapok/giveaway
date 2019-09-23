<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LangController extends Controller {
    use ProcessTokenTrait;
    var $locale;

    function __construct() {
        $locale = app()->getLocale();
        $localeCookie = Cookie::get("lang");
        if ($localeCookie){
            $locale = $localeCookie;
        }
        $this->locale = $locale;
    }

    function index($step, Request $request) {
        return  __($step, [], $this->locale);
    }

    function task(Task $task, Request $request) {
        $arr = [];
        $arr[$task->type]  = __("tasks.".$task->type, ["tickets" => $task->tickets], $this->locale);
        return $arr;
    }
}
