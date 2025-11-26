<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Order $model)
    {
        //
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $order_id): ?Order
    {
        return $this->model->find($order_id);
    }

    public function getLatestUserOrder($limit = 10)
    {
        return $this->model->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->take($limit)->get();
    }

    public function getFirstLatestOrder()
    {
        return $this->model->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
    }
}
