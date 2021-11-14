<?php

namespace App\Services;

use App\Exceptions\TicketAlreadyUsedException;
use App\Exceptions\TicketInvalidOwnerException;
use App\Exceptions\TicketNotFoundException;
use App\Models\Order;
use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Services\Contracts\TicketServiceInterface;

class TicketService implements TicketServiceInterface
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticket_repository;

    public function __construct(TicketRepositoryInterface $ticket_repository)
    {
        $this->ticket_repository = $ticket_repository;
    }

    public function getByOrderId(string $order_id)
    {
        $tickets = $this->ticket_repository->getByOrderId($order_id);
        return $tickets;
    }

    public function getByUserId(string $user_id)
    {
        $tickets = $this->ticket_repository->getByUserId($user_id);
        return $tickets;
    }

    public function find(string $id)
    {
        $ticket = $this->ticket_repository->find($id);
        if (!$ticket) {
            throw new TicketNotFoundException();
        }

        return $ticket;
    }

    public function generate(Order $order)
    {
        $tickets = collect();
        for ($i=0; $i < $order->qty; $i++) { 
            $ticket = new Ticket();
            $ticket->order_id = $order->id;
            $ticket->price = $order->subtotal / $order->qty;
            $ticket->used_at = null;

            $this->ticket_repository->save($ticket);

            $tickets->push($ticket);
        }

        return $tickets;
    }

    public function use(string $id, string $user_id)
    {
        $ticket = $this->find($id);

        if ($ticket->order->user_id != $user_id) {
            throw new TicketInvalidOwnerException();
        }
        elseif (!is_null($ticket->used_at)) {
            throw new TicketAlreadyUsedException();
        }

        $ticket->used_at = now();
        $this->ticket_repository->save($ticket);

        return $ticket;
    }
}
