<?php

namespace App\Interfaces\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Transaction;

    public function getFirstTransaction($order_id);
}
