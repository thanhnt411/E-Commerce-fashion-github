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

    //START Slides
    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

    public function add_slides()
    {
        return view('admin.add-slides');
    }

    public function store_slides(StoreSlideRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('slides', $fileName);
        }

        $data['image'] =  $path;
        $slides = Slide::create($data);
        return redirect()->route('admin.slides')->with('status', 'Slide created successfully!');
    }

    public function edit_slides(Slide $slide)
    {
        return view('admin.edit-slides', [
            'slides' => $slide
        ]);
    }

    public function update_slides(StoreSlideRequest $request, Slide $slide)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($slide->image && Storage::exists($slide->image)) {
                Storage::delete($slide->image);
            }
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('slides', $fileName);
        }
        $data['image'] =  $path;
        $slide->update($data);
        return redirect()->route('admin.slides')->with('status', 'Slides updated successfully!');
    }

    public function delete_slides(Slide $slide)
    {
        if ($slide->image && Storage::exists($slide->image)) {
            Storage::delete($slide->image);
        }
        $slide->delete();
        return back()->with('status', 'Slides deleted successfully!');
    }
    //END Sliedes

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
