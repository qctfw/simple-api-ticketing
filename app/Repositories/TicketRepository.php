<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;

class TicketRepository implements TicketRepositoryInterface
{
    public function getByUserId(string $user_id)
    {
        return Ticket::query()->whereRelation('order', 'user_id', '=', $user_id)->get();
    }

    public function getByOrderId(string $order_id)
    {
        return Ticket::where('order_id', $order_id)->get();
    }

    public function find(string $id): ?Ticket
    {
        return Ticket::find($id);
    }

    public function save(Ticket $ticket): bool
    {
        return $ticket->save();
    }
}
