<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function find(string $id): ?Order
    {
        return Order::with(['event', 'user'])->find($id);
    }

    public function getByUserId(string $user_id)
    {
        return Order::with(['event', 'user'])->where('user_id', $user_id)->get();
    }

    public function save(Order $order): bool
    {
        return $order->save();
    }
}
