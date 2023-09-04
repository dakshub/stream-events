<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
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

    public function index(Request $request)
    {
        $events = $this->eventService->getUserEvents($request->user());

        return EventResource::collection($events);
    }

    public function update(EventUpdateRequest $request)
    {
        $eventId = $request->route('id');
        $requestArray = json_decode($request->getContent(), true);
        $eventResponse = $this->eventService->updateEvent($eventId, $requestArray);

        return response()
            ->json($eventResponse, JsonResponse::HTTP_OK);
    }
}
