<?php

namespace App\Services\Contracts;

interface EventServiceInterface
{
    public function get();
    public function getAvailableEvents(int $per_page = 10);
    public function find(string $id);
}
