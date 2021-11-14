<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Services\Contracts\EventServiceInterface;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @var EventServiceInterface
     */
    private $event_service;

    public function __construct(EventServiceInterface $event_service)
    {
        $this->event_service = $event_service;
    }

    public function index(Request $request)
    {
        $resource = $this->event_service->getAvailableEvents($request->per_page ?: 10);

        return EventResource::collection($resource);
    }

    public function show($id)
    {
        $resource = $this->event_service->find($id);

        return new EventResource($resource);
    }
}
