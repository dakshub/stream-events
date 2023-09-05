<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{

    public function getLatestPaginatedUserEvents(int $userId, int $perPage): LengthAwarePaginator
    {
        return Event::where('user_id', $userId)->orderBy('created_at', 'ASC')->paginate($perPage);
    }

    public function updateEvent(int $eventId, array $eventArray): Event
    {
        $event = Event::find($eventId);
        $event->fill($eventArray);
        $event->save();

        return $event;
    }
}
