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
        return  __($step, ["winner_date" => config("giveaway.announcementDate")], $this->locale);
    }

    function task(Task $task, Request $request) {
        $arr = [];
        $arr[$task->type]  = __("tasks.".$task->type, [], $this->locale);
        $arr["tickets_message"]  = __("tasks.tickets_message", ["tickets" => $task->tickets], $this->locale);
        return $arr;
    }
}
