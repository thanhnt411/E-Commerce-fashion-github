<?php

namespace App\Interfaces\Services;

interface UserServiceInterface
{
    public function getUserOrder();

    public function getOrderId($order_id);

    public function getUserData($order_id);

    public function getUserAddress();

    public function getWishlistItem();
}
