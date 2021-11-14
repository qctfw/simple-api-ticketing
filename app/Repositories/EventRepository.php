<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    public function all()
    {
        return Event::all();
    }

    public function find(string $id): ?Event
    {
        return Event::find($id);
    }

    public function getAvailableEvents(int $per_page = 10)
    {
        return Event::query()->available()->paginate($per_page);
    }

    public function save(Event $event): bool
    {
        return $event->save();
    }
}
