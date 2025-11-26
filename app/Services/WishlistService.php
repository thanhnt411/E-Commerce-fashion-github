<?php

namespace App\Services;

use App\DTOs\WishlistData;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Interfaces\Services\WishlistServiceInterface;

class WishlistService implements WishlistServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return Cart::instance('wishlist')->content();
    }

    public function AddWishlist($data)
    {
        return  Cart::instance('wishlist')->add($data)->associate('App\Models\Product');
    }

    public function removeItem($rowId)
    {
        return Cart::instance('wishlist')->remove($rowId);
    }

    public function removeAll()
    {
        return Cart::instance('wishlist')->destroy();
    }

    public function getId($rowId)
    {
        return Cart::instance('wishlist')->get($rowId);
    }

    public function moveToCart($data)
    {
        return Cart::instance('cart')->add($data)->associate('App\Models\Product');
    }
}
