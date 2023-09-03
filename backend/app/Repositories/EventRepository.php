<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{

    public function getLatestPaginatedUserEvents(User $user, int $perPage): LengthAwarePaginator
    {
        return Event::where('user_id', $user->id)->orderBy('created_at', 'ASC')->paginate($perPage);
    }
}
