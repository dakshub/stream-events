<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request): JsonResponse
    {
        $events = $this->eventService->getUserEvents($request->user());

        return EventResource::collection($events)->response();
    }

    public function update(EventUpdateRequest $request): JsonResponse
    {
        $eventId = $request->route('id');
        $requestArray = json_decode($request->getContent(), true);
        $eventResponse = $this->eventService->updateEvent($eventId, $requestArray);

        return EventResource::make($eventResponse)->response();
    }
}
