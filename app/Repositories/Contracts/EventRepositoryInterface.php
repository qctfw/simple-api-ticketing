<?php

namespace App\Repositories\Contracts;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function all();
    public function find(string $id): ?Event;
    public function getAvailableEvents(int $per_page = 10);
    public function save(Event $event): bool;
}
