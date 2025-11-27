<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreAddressRequest;
use App\Interfaces\Services\CartServiceInterface;
use App\Models\OrderItem;
use App\Models\Transaction;

class CartController extends Controller
{
    public function __construct(protected CartServiceInterface $cartService) {}

    public function index()
    {
        $items = $this->cartService->getAll();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $data = [
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->quantity,
            'price' => $request->price,
        ];
        $this->cartService->addItem($data);
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = $this->cartService->getId($rowId);
        $qty = $product->qty + 1;
        $this->cartService->updateQuantity($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = $this->cartService->getId($rowId);
        $qty = $product->qty - 1;
        $this->cartService->updateQuantity($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        $this->cartService->removeItem($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        $this->cartService->removeAllItem();
        return redirect()->back();
    }

    public function apply_coupons_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $coupon = $this->cartService->getCouponCode($coupon_code);
            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon_code!');
            } else {
                $this->cartService->putSession($coupon);
                return redirect()->back()->with('success', 'Coupon has been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid coupon_code!');
        }
    }

    public function remove_coupon_code()
    {
        $this->cartService->removeCoupon();
        return redirect()->back()->with('success', 'Coupon remove success!');
    }

    public function checkout()
    {
        $account = $this->cartService->checkAuth();
        if (!$account) {
            return redirect()->route('login');
        }
        $user_id = $this->cartService->getUserId();
        $address = $this->cartService->getAddress($user_id);
        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = $this->cartService->getUserId();
        $address = $this->cartService->getAddress($user_id);
        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required|',
                'city' => 'required|',
                'address' => 'required|',
                'locality' => 'required|',
                'landmark' => 'required|',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'VietNam';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }
        $this->cartService->setAmountforCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount =  Session::get('checkout')['discount'];
        $order->tax =  Session::get('checkout')['tax'];
        $order->total =  Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach ($this->cartService->getAll() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }

        if ($request->mode == "card") {
            //
        } elseif ($request->mode == "paypal") {
            //
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }
        $this->cartService->removeAllItem();
        $this->cartService->removeCheckout();
        $this->cartService->removeCoupon();
        $this->cartService->putOrderId($order);
        return redirect()->route('cart.order.confirmation');
    }

    public function order_confirmation()
    {
        if ($this->cartService->confirmOrder()) {
            $order = $this->cartService->getOrderId();
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
