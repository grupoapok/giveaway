<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskCompletionResource extends JsonResource {

    public function toArray($request) {
        return [
            "id" => $this->id,
            "task" => TaskResource::make($this->whenLoaded("task")),
            "created_at" => $this->created_at->format("Y-m-d")
        ];
    }
}
