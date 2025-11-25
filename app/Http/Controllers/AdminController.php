<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreCategoryRequest;


class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                                    sum(if(status = 'ordered', total, 0)) As TotalOrderedAmount,
                                    sum(if(status = 'delivered', total, 0)) As TotalDeliveredAmount,
                                    sum(if(status = 'canceled', total, 0)) As TotalCanceledAmount,
                                    Count(*) As Total,
                                    sum(if(status = 'ordered', 1, 0)) As TotalOrdered,
                                    sum(if(status = 'delivered', 1, 0)) As TotalDelivered,
                                    sum(if(status = 'canceled', 1, 0)) As TotalCanceled
                                    From  Orders 
                                    ");
        return view('admin.index', compact('orders', 'dashboardDatas'));
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.add-brand');
    }

    public function store_brand(StoreBrandRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('brands', $fileName);
        }
        /*$img = Image::read($file->getRealPath());
        $img->resize(800, null, function ($const) {
            $const->aspectRatio();
            $const->upsize();
        });
        $path = 'brands/' . $fileName;
        Storage::disk('public')->put($path, (string) $img->endcode());*/
        $data['image'] =  $path;
        $brands = Brand::create($data);
        return redirect()->route('admin.brands')->with('status', 'Brand created successfully!');
    }

    public function edit_brand(Brand $brand)
    {
        return view('admin.edit-brand', [
            'brands' => $brand
        ]);
    }

    public function update_brand(StoreBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($brand->image && Storage::exists($brand->image)) {
                Storage::delete($brand->image);
            }
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('brands', $fileName);
        }
        $data['image'] =  $path;
        $brand->update($data);
        return redirect()->route('admin.brands')->with('status', 'Brand updated successfully!');
    }

    public function delete_brand(Brand $brand)
    {
        if ($brand->image && Storage::exists($brand->image)) {
            Storage::delete($brand->image);
        }
        $brand->delete();
        return back()->with('status', 'Brand deleted successfully!');
    }

    //START Categories
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_categories()
    {
        return view('admin.add-categories');
    }

    public function store_categories(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('categories', $fileName);
        }

        $data['image'] =  $path;
        $categories = Category::create($data);
        return redirect()->route('admin.categories')->with('status', 'Category created successfully!');
    }

    public function edit_categories(Category $category)
    {
        return view('admin.edit-categories', [
            'categories' => $category
        ]);
    }

    public function update_categories(StoreCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($category->image && Storage::exists($category->image)) {
                Storage::delete($category->image);
            }
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('categories', $fileName);
        }
        $data['image'] =  $path;
        $category->update($data);
        return redirect()->route('admin.categories')->with('status', 'Categories updated successfully!');
    }

    public function delete_categories(Category $category)
    {
        if ($category->image && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }
        $category->delete();
        return back()->with('status', 'Categories deleted successfully!');
    }
    //END Categories

    //START Products
    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_products()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.add-products', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store_products(StoreProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $Mainpath = $file->storeAs('products', $fileName);
            $data['image'] = $Mainpath;
        }

        $gallery = [];
        $count = 1;
        if ($request->hasFile('images')) {
            $files = (array) $request->file('images');
            foreach ($files as $file) {
                $fileNameG = now()->timestamp . '-' . uniqid() . '-' . $count . '.' . $file->extension();

                $galleryPath = $file->storeAs('products/thumbnail', $fileNameG);
                $gallery[] = $galleryPath;
                $count = $count + 1;
            }
            $data['images'] = implode(',', $gallery);
        }
        $products = Product::create($data);
        return redirect()->route('admin.products')->with('status', 'Products created successfully!');
    }

    public function edit_products(Product $product)
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.edit-products', [
            'products' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update_products(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $Mainpath = $file->storeAs('products', $fileName);
            $data['image'] = $Mainpath;
        }

        $gallery = [];
        $count = 1;
        if ($request->hasFile('images')) {
            $files = (array) $request->file('images');
            foreach ($files as $file) {
                $fileNameG = now()->timestamp . '-' . uniqid() . '-' . $count . '.' . $file->extension();
                $galleryPath = $file->storeAs('products/thumbnail', $fileNameG);
                $gallery[] = $galleryPath;
                $count = $count + 1;
            }
        }
        if (!empty($gallery)) {
            foreach (explode(',', $product->images) as $olFile) {
                if (Storage::exists(trim($olFile))) {
                    Storage::delete($olFile);
                }
            }
        }
        $data['images'] = implode(',', $gallery);

        $product->update($data);
        return redirect()->route('admin.products')->with('status', 'Products updated successfully!');
    }

    public function delete_products(Product $product)
    {
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        foreach (explode(',', $product->images) as $olFile) {
            if (Storage::exists(trim($olFile))) {
                Storage::delete($olFile);
            }
        }
        $product->delete();
        return back()->with('status', 'Products deleted successfully!');
    }
    //END Products

    //START Coupons
    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(10);
        return view('admin.coupons', compact('coupons'));
    }

    public function add_coupons()
    {
        return view('admin.add-coupons');
    }

    public function store_coupons(StoreCouponRequest $request)
    {
        $data = $request->validated();
        $coupons = Coupon::create($data);
        return redirect()->route('admin.coupons')->with('satus', 'Coupons created successfully!');
    }

    public function edit_coupons(Coupon $coupon)
    {
        return view('admin.edit-coupons', [
            'coupons' => $coupon
        ]);
    }

    public function update_coupons(StoreCouponRequest $request, Coupon $coupon)
    {
        $data = $request->validated();
        $coupon->update($data);
        return redirect()->route('admin.coupons')->with('satus', 'Coupons updated successfully!');
    }

    public function delete_coupons(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('status', 'Coupons deleted successfully!');
    }
    //END Coupons

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
