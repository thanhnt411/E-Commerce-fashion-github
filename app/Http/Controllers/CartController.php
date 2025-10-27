<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreAddressRequest;
use App\Models\OrderItem;
use App\Models\Transaction;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupons_code(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon_code!');
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculateDiscout();
                return redirect()->back()->with('success', 'Coupon has been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid coupon_code!');
        }
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

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon remove success!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdeafult', 1)->first();
        return view('checkout', compact('address'));
    }

    public function place_an_order(StoreAddressRequest $request)
    {
        dd(Session::get('checkout'));
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdeafult', true)->first();
        if (!$address) {
            $data = $request->validated();
            $data['user_id'] = $user_id;
            $data['country'] = 'Vietnam';
            $data['isdeafult'] = true;
            $address = Address::create($data);
        }
        $this->setAmountforCheckout();
        $checkout = Session::get('checkout');



        $order = Order::create([
            'user_id' => $user_id,
            'subtotal' => $checkout['subtotal'],
            'discount' => $checkout['discount'],
            'tax' => $checkout['tax'],
            'total' => $checkout['total'],
            'name' => $address->name,
            'phone' => $address->phone,
            'locality' => $address->locality,
            'address' => $address->address,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country,
            'landmark' => $address->landmark,
            'zip' => $address->zip,
        ]);

        foreach (Cart::instance('cart')->content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->qty
            ]);
        }

        if ($request->mode == 'card') {
            # code...
        } elseif ($request->mode == 'paypal') {
            # code...
        } elseif ($request->mode == 'cod') {
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode' => $request->mode,
                'status' => 'pending',
            ]);
        }

        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discount');
        Session::put('order_id', $order->id);
        return redirect()->route('cart.confirm');
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

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
