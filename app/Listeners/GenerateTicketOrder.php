<?php

namespace App\Listeners;

use App\Events\OrderSuccessful;
use App\Services\Contracts\TicketServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateTicketOrder
{
    /**
     * @var TicketServiceInterface
     */
    private $ticket_service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TicketServiceInterface $ticket_service)
    {
        $this->ticket_service = $ticket_service;
    }

    /**
     * Handle the event.
     *
     * @param  OrderSuccessful  $event
     * @return void
     */
    public function handle(OrderSuccessful $event)
    {
        $this->ticket_service->generate($event->order);
    }
}
