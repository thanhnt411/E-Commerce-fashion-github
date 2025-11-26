<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\UserServiceInterface;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class UserController extends Controller
{
    public function __construct(protected UserServiceInterface $userService) {}

    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $order = $this->userService->getUserOrder();
        return view('user.orders', [
            'orders' => $order
        ]);
    }

    public function orders_details($order_id)
    {
        $orders = $this->userService->getOrderId($order_id);
        $data = $this->userService->getUserData($order_id);
        return view(
            'user.orders-details',
            array_merge($data, [
                'orders' => $orders
            ])
        );
    }

    public function address()
    {
        $orders = $this->userService->getUserAddress();
        return view('user.address', compact('orders'));
    }

    public function details()
    {
        return view('user.details');
    }

    public function wishlist()
    {
        $items = $this->userService->getWishlistItem();
        return view('user.wishlist', compact('items'));
    }
}
