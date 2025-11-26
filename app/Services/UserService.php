<?php

namespace App\Services;

use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\OrderItemRepositoryInterface;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OrderRepositoryInterface $orderRepo,
        protected OrderItemRepositoryInterface $orderItemRepo,
        protected TransactionRepositoryInterface $transactionRepo
    ) {}

    public function getUserOrder()
    {
        return $this->orderRepo->getLatestUserOrder(10);
    }

    public function getOrderId($order_id)
    {
        $order = $this->orderRepo->find($order_id);
        if (!$order) {
            abs(404, 'Không tìm thấy đơn hàng');
        }
        return $order;
    }

    public function getUserData($order_id)
    {
        return [
            'orderItems' => $this->orderItemRepo->getLatestOrderItem($order_id, 10),
            'transactions' => $this->transactionRepo->getFirstTransaction($order_id),
        ];
    }

    public function getUserAddress()
    {
        return $this->orderRepo->getFirstLatestOrder();
    }

    public function getWishlistItem()
    {
        return Cart::instance('wishlist')->content();
    }
}
