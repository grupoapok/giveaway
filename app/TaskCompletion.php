<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class TaskCompletion extends Model
{
    use HasTimestamps;

    protected $fillable = ["subscriber_id", "task_id"];

    protected $with = ["task"];

    function subscriber() {
        return $this->belongsTo("App\Subscriber");
    }

    function task() {
        return $this->belongsTo("App\Task");
    }
}
