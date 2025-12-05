<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Interfaces\Services\AdminServiceInterface;

class AdminController extends Controller
{
    public function __construct(protected AdminServiceInterface $adminService) {}

    public function index()
    {
        $orders = $this->adminService->getOrderCreatedDESC();
        $dashboardDatas = $this->adminService->selectTotal();
        return view('admin.index', compact('orders', 'dashboardDatas'));
    }

    //START Contact
    public function contacts()
    {
        $contacts = Contact::orderBy('id', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }
    //END Contact

    //START Order
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function orders_details(Order $order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(10);
        $transactions = Transaction::where('order_id', $order->id)->first();
        return view('admin.orders-details', [
            'orders' => $order,
            'orderItems' => $orderItems,
            'transactions' => $transactions
        ]);
    }
    //END Order

    //START User
    public function users()
    {
        $users = User::orderBy('id', 'DESC')->paginate(12);
        return view('admin.users', compact('users'));
    }
    //END User

    //START Setting
    public function settings()
    {
        return view('admin.settings');
    }
    //END Setting
}
