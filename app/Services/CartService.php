<?php

namespace App\Services;

use App\DTOs\CartData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\CouponRepositoryInterface;
use App\Interfaces\Repositories\AddressRepositoryInterface;


class CartService implements CartServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CouponRepositoryInterface $couponRepo,
        protected AddressRepositoryInterface $addressRepo,
        protected OrderRepositoryInterface $orderRepo
    ) {
        //
    }

    public function getAll()
    {
        return Cart::instance('cart')->content();
    }

    public function addItem($data)
    {
        return  Cart::instance('cart')->add($data)->associate('App\Models\Product');
    }

    public function getId($rowId)
    {
        return Cart::instance('cart')->get($rowId);
    }

    public function updateQuantity($rowId, $qty)
    {
        return  Cart::instance('cart')->update($rowId, $qty);
    }

    public function removeItem($rowId)
    {
        return  Cart::instance('cart')->remove($rowId);
    }

    public function removeAllItem()
    {
        return Cart::instance('cart')->destroy();
    }

    public function getCouponCode($coupon_code)
    {
        return  $this->couponRepo->getCouponCode($coupon_code)->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
    }

    public function putSession($coupon)
    {
        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);
        $discount = $this->calculateDiscout();
        return $discount;
    }

    public function calculateDiscout()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = Cart::instance('cart')->subtotal() * Session::get('coupon')['value'] / 100;
            }
            $subTotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxTotalAfterDiscount = ($subTotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterTax = $subTotalAfterDiscount + $taxTotalAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', '.'),
                'subtotal' => number_format(floatval($subTotalAfterDiscount), 2, '.', '.'),
                'tax' => number_format(floatval($taxTotalAfterDiscount), 2, '.', '.'),
                'total' => number_format(floatval($totalAfterTax), 2, '.', '.'),
            ]);
        }
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return;
    }

    public function removeCheckout()
    {
        return  Session::forget('checkout');
    }

    public function checkAuth()
    {
        return Auth::check();
    }

    public function getUserId()
    {
        return Auth::user()->id;
    }

    public function getAddress($user_id)
    {
        return $this->addressRepo->getAddress($user_id);
    }

    public function createAddress($data)
    {
        return $this->addressRepo->create($data);
    }

    public function setAmountforCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function putOrderId($order)
    {
        return Session::put('order_id', $order->id);
    }

    public function confirmOrder()
    {
        return Session::has('order_id');
    }

    public function getOrderId()
    {
        $order_id = Session::get('order_id');
        return $this->orderRepo->findOrFail($order_id);
    }
}
