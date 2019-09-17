<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model {
    protected $fillable = ["name", "email"];
    protected $hidden = ["updated_at", "created_at" ,"ipinfo"];
    protected $with = ["tickets"];

    public function tickets(){
        return $this->hasMany("App\Ticket");
    }
}
