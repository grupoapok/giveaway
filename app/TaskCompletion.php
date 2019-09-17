<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskCompletion extends Model
{
    protected $fillable = ["subscriber_id", "task_id"];

    function subscriber() {
        return $this->belongsTo("App\Subscriber");
    }

    function task() {
        return $this->belongsTo("App\Task");
    }
}
