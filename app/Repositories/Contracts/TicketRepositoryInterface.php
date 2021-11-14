<?php

namespace App\Repositories\Contracts;

use App\Models\Ticket;

interface TicketRepositoryInterface
{
    public function getByUserId(string $user_id);
    public function getByOrderId(string $order_id);
    public function find(string $id): ?Ticket;
    public function save(Ticket $ticket): bool;
}
