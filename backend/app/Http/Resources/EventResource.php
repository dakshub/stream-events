<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request): array
    {
        $eventableTypeArray = explode('\\', $this->eventable_type);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => end($eventableTypeArray),
            'is_read' => (bool) $this->is_read,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'eventable' => $this->eventable
        ];
    }
}
