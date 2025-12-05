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
    public function __construct(protected Coupon $model) {}

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
        return $this->model->where('code', $coupon_code);
    }

    public function getExpiryDate()
    {
        return  $this->model->orderBy('expiry_date', 'DESC')->paginate(10);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function  update($coupon, $data)
    {
        return $coupon->update($data);
    }

    public function delete($coupon)
    {
        return $coupon->delete();
    }
}
