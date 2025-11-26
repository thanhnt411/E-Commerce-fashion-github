<?php

namespace App\Interfaces\Repositories;

use App\Models\OrderItem;
use Illuminate\Support\Collection;

interface OrderItemRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?OrderItem;

    public function getLatestOrderItem(int $order_id, int $limit);
}
