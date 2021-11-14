<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function find(string $id): ?Order;
    public function getByUserId(string $user_id);
    public function save(Order $order): bool;
}
