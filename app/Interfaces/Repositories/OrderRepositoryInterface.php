<?php

namespace App\Interfaces\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function all(): Collection;

    public function find(int $order_id): ?Order;

    public function getLatestUserOrder(int $limit);

    public function getFirstLatestOrder();

    public function getOrderCreatedDESC();
}
