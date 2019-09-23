<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource {

    public function toArray($request) {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "type" => $this->type,
            "tickets" => $this->tickets,
            "url" => $this->url
        ];
    }
}
