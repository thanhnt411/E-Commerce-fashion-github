<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\WishlistServiceInterface;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(protected WishlistServiceInterface $wishlistService) {}

    public function index()
    {
        $items = $this->wishlistService->getAll();
        return view('wishlist', compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        $data = [
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->quantity,
            'price' => $request->price
        ];

        $this->wishlistService->AddWishlist($data);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        $this->wishlistService->removeItem($rowId);
        return redirect()->back();
    }

    public function empty_item()
    {
        $this->wishlistService->removeAll();
        return redirect()->back();
    }

    public function move_to_cart($rowId)
    {

        $item = $this->wishlistService->getId($rowId);
        $data = [
            'id' => $item->id,
            'name' => $item->name,
            'qty' => $item->qty,
            'price' => $item->price
        ];
        $this->wishlistService->moveToCart($data);
        $this->wishlistService->removeItem($rowId);
        return redirect()->back();
    }
}
