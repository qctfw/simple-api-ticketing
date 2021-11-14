<?php

namespace App\Services;

use App\Events\OrderSuccessful;
use App\Exceptions\EventNotFoundException;
use App\Exceptions\OrderInvalidPaymentStatusException;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderQuantityExceededException;
use App\Models\Order;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService implements OrderServiceInterface
{
    /**
     * @var EventRepositoryInterface
     */
    private $event_repository;
    
    /**
     * @var OrderRepositoryInterface
     */
    private $order_repository;

    public function __construct(EventRepositoryInterface $event_repository, OrderRepositoryInterface $order_repository)
    {
        $this->event_repository = $event_repository;
        $this->order_repository = $order_repository;
    }

    public function getById(string $id)
    {
        $order = $this->order_repository->find($id);
        if (!$order)
            throw new OrderNotFoundException();

        return $order;
    }

    public function getByUserId(string $user_id)
    {
        return $this->order_repository->getByUserId($user_id);
    }

    public function create(string $event_id, string $user_id, int $qty)
    {
        $event = $this->event_repository->find($event_id);

        if (!$event) {
            throw new EventNotFoundException();
        }
        elseif ($event->remaining_tickets < $qty) {
            throw new OrderQuantityExceededException($event->remaining_tickets);
        }

        $order = new Order();
        $order->user_id = $user_id;
        $order->event_id = $event_id;
        $order->qty = $qty;
        $order->subtotal = $event->price * $qty;
        $order->total = $event->price * $qty;
        $order->payment_status = Order::PAYMENT_STATUS_PENDING;

        $this->order_repository->save($order);
        return $order;
    }

    public function confirm(string $id)
    {
        $order = $this->getById($id);
        if ($order->payment_status != Order::PAYMENT_STATUS_PENDING) {
            throw new OrderInvalidPaymentStatusException();
        }
        elseif ($order->event->remaining_tickets < $order->qty) {
            throw new OrderQuantityExceededException($order->event->remaining_tickets);
        }

        $event = $this->event_repository->find($order->event_id);
        $event->remaining_tickets -= $order->qty;
        
        $order->payment_status = Order::PAYMENT_STATUS_DONE;
        
        $this->order_repository->save($order);
        $this->event_repository->save($event);

        OrderSuccessful::dispatch($order);

        return $this->order_repository->find($order->id);
    }

    public function cancel(string $id)
    {
        $order = $this->getById($id);
        if ($order->payment_status != Order::PAYMENT_STATUS_PENDING)
            throw new OrderInvalidPaymentStatusException();

        $order->payment_status = Order::PAYMENT_STATUS_CANCELED;

        $this->order_repository->save($order);
        return $order;
    }
}
