<?php

namespace App\Services\Admin;

use App\Interfaces\Repositories\CouponRepositoryInterface;
use App\Interfaces\Services\Admin\CouponServiceInterface;
use App\Models\Coupon;

class CouponService implements CouponServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected CouponRepositoryInterface $couponRepo) {}

    public function getExpiryDate()
    {
        return $this->couponRepo->getExpiryDate();
    }

    public function store(array $data)
    {
        return $this->couponRepo->create($data);
    }

    public function update(Coupon $coupon, array $data)
    {
        return $this->couponRepo->update($coupon, $data);
    }

    public function delete(Coupon $coupon)
    {
        return $this->couponRepo->delete($coupon);
    }
}
