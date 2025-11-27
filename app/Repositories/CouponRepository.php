<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CouponRepositoryInterface;
use App\Models\Coupon;
use Illuminate\Support\Collection;

class CouponRepository implements CouponRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Coupon $model)
    {
        //
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Coupon
    {
        return $this->model->find($id);
    }

    public function getCouponCode($coupon_code)
    {
        return Coupon::where('code', $coupon_code);
    }
}
