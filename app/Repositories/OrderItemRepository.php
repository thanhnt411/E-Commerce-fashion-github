<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrderItemRepositoryInterface;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected OrderItem $model)
    {
        //
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?OrderItem
    {
        return $this->model->find($id);
    }

    public function getLatestOrderItem($order_id, $limit = 10)
    {
        return $this->model->where('order_id', $order_id)->orderBy('id')->take($limit)->get();
    }
}
