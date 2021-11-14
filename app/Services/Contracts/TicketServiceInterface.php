<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface TicketServiceInterface
{
    public function getByOrderId(string $order_id);
    public function getByUserId(string $user_id);
    public function find(string $id);
    public function generate(Order $order);
    public function use(string $id, string $user_id);
}
