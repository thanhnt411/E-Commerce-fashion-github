<?php

namespace App\Interfaces\Repositories;

use App\Models\Coupon;
use Illuminate\Support\Collection;

interface CouponRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Coupon;

    public function getCouponCode($coupon_code);
}
