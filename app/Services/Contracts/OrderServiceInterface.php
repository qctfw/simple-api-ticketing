<?php

namespace App\Services\Contracts;

interface OrderServiceInterface
{
    public function getById(string $id);
    public function getByUserId(string $user_id);
    public function create(string $event_id, string $user_id, int $qty);
    public function confirm(string $id);
    public function cancel(string $id);
}
