<?php

namespace App\Interfaces\Services;

use App\DTOs\CartData;


interface CartServiceInterface
{
    public function getAll();

    public function getId($rowId);

    public function addItem($data);

    public function updateQuantity($rowId, $qty);

    public function removeItem($rowId);

    public function removeAllItem();

    public function getCouponCode($coupon_code);

    public function putSession($coupon);

    public function removeCoupon();

    public function checkAuth();

    public function getAddress($user_id);

    public function createAddress($data);

    public function getUserId();

    public function setAmountforCheckout();

    public function removeCheckout();

    public function putOrderId($order);

    public function confirmOrder();

    public function getOrderId();
}
