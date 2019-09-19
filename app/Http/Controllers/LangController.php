<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProcessTokenTrait;
use Illuminate\Http\Request;

class LangController extends Controller {
    use ProcessTokenTrait;

    function index($step, Request $request) {
        $user = $this->getUser($request);
        $tickets = 0;
        if (!is_null($user)){
            $tickets = count($user->tickets);
        }
        $arr = __($step);
        $res = [];
        foreach($arr as $key => $val) {
            $res[$key] = trans_choice($step.".".$key, $tickets);
        }
        return $res;
    }
}
