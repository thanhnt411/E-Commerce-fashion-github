<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Interfaces\Services\Admin\CouponServiceInterface;

class CouponController extends Controller
{
    public function __construct(protected CouponServiceInterface $couponService) {}

    public function index()
    {
        $coupons = $this->couponService->getExpiryDate();
        return view('admin.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('admin.add-coupons');
    }

    public function store(StoreCouponRequest $request)
    {
        $this->couponService->store($request->validated());
        return redirect()->route('admin.coupons')->with('satus', 'Coupons created successfully!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.edit-coupons', [
            'coupons' => $coupon
        ]);
    }

    public function update(StoreCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        $this->couponService->update($coupon, $request->validated());
        return redirect()->route('admin.coupons')->with('satus', 'Coupons updated successfully!');
    }

    public function delete(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);
        $this->couponService->delete($coupon);
        return redirect()->back()->with('status', 'Coupons deleted successfully!');
    }
}
