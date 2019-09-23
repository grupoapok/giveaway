<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource {
    public function toArray($request) {
        return [
            "id" => $this->id,
            "task_completion" => TaskCompletionResource::make($this->whenLoaded("taskCompletion"))
        ];
    }
}
