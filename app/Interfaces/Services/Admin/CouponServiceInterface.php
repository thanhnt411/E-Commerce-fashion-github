<?php

namespace App\Interfaces\Services\Admin;

use App\Models\Coupon;

interface CouponServiceInterface
{

    public function getExpiryDate();

    public function store(array $data);

    public function update(Coupon $coupon, array $data);

    public function delete(Coupon $coupon);
}
