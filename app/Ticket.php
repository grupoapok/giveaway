<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $hidden = ["task_completions_id"];

    protected $fillable = ["subscriber_id", "task_completions_id"];

    protected $with = ["taskCompletion"];

    function taskCompletion() {
        return $this->belongsTo("\App\TaskCompletion", "task_completions_id");
    }
}
