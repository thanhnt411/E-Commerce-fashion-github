<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Transaction $model)
    {
        //
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Transaction
    {
        return $this->model->find($id);
    }

    public function getFirstTransaction($order_id)
    {
        return $this->model->where('order_id', $order_id)->first();
    }
}
