<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\EventRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService
{
    public const EVENTS_PER_PAGE = 100;
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getUserEvents(User $user): LengthAwarePaginator
    {
        return $this->eventRepository->getLatestPaginatedUserEvents($user, self::EVENTS_PER_PAGE);
    }
}
