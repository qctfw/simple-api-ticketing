<?php

namespace App\Services;

use App\Exceptions\EventNotFoundException;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Services\Contracts\EventServiceInterface;

class EventService implements EventServiceInterface
{
    /**
     * @var EventRepositoryInterface
     */
    private $event_repository;

    public function __construct(EventRepositoryInterface $event_repository)
    {
        $this->event_repository = $event_repository;
    }

    public function get()
    {
        return $this->event_repository->all();
    }

    public function getAvailableEvents(int $per_page = 10)
    {
        return $this->event_repository->getAvailableEvents($per_page);
    }

    public function find(string $id)
    {
        $event = $this->event_repository->find($id);
        if (!$event) {
            throw new EventNotFoundException();
        }

        return $event;
    }
}
