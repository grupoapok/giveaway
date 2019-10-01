<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {
    use SoftDeletes;

    const CONFIRM_AUTO = "auto";
    const CONFIRM_MANUAL = "manual";

    protected $fillable = ["description", "type", "tickets" ,"url", "repeatable", "confirm_type"];

    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    protected $casts = [
        "repeatable" => "boolean"
    ];

    var $completed = false;
    var $status = null;

    public function toArray() {
        return array_merge(["completed" => $this->completed],parent::toArray());
    }

    public function isAuto() {
        return $this->confirm_type == Task::CONFIRM_AUTO;
    }

    public function isRepeatable() {
        return $this->repeatable;
    }
}
