<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {
    use SoftDeletes;

    protected $fillable = ["description", "type", "tickets"];
    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    protected $casts = [
        "repeatable" => "boolean"
    ];

    var $completed = false;

    public function toArray() {
        return array_merge(["completed" => $this->completed],parent::toArray());
    }

}
