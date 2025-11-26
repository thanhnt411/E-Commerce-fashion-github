<?php

namespace App\Interfaces\Services;

use App\DTOs\WishlistData;

interface WishlistServiceInterface
{
    public function getAll();

    public function AddWishlist($data);

    public function removeitem($rowId);

    public function removeAll();

    public function getId($rowId);

    public function moveToCart($data);
}
