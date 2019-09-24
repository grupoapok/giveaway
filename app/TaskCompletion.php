<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class TaskCompletion extends Model {
    use HasTimestamps;

    const STATUS_COMPLETED = "completed";
    const STATUS_INCOMPLETE = "incomplete";

    protected $fillable = ["subscriber_id", "task_id", "status", "extras"];

    protected $with = ["task"];

    function subscriber() {
        return $this->belongsTo("App\Subscriber");
    }

    function task() {
        return $this->belongsTo("App\Task");
    }

    function scopeBySubscriber($query, $subscriber_id){
        return $query->where("subscriber_id", $subscriber_id);
    }

    function scopeByTask($query,$task_id) {
        return $query->where("task_id", $task_id);
    }

    function scopeCompleted($query) {
        return $query->where("status", TaskCompletion::STATUS_COMPLETED);
    }

    function scopeIncomplete($query) {
        return $query->where("status", TaskCompletion::STATUS_INCOMPLETE);
    }

    function scopeManual($query) {
        return $query->join("tasks", "tasks.id", "=", "task_completions.task_id")->where("tasks.confirm_type", Task::CONFIRM_MANUAL);
    }
}
