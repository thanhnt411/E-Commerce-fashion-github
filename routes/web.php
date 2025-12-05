<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about', [HomeController::class, 'about'])->name('about.index');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::prefix('/contact')->group(function () {
    Route::get('/', [HomeController::class, 'contact'])->name('contact.index');
    Route::post('/store', [HomeController::class, 'store_contact'])->name('contact.store');
});

Route::prefix('/shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/{product_slug}', [ShopController::class, 'products_detail'])->name('shop.product.details');
});

Route::prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::put('/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
    Route::put('/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
    Route::delete('/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
    Route::delete('/empty', [CartController::class, 'empty_cart'])->name('cart.empty');

    Route::prefix('coupons')->group(function () {
        Route::post('/', [CartController::class, 'apply_coupons_code'])->name('cart.coupons');
        Route::delete('/remove', [CartController::class, 'remove_coupon_code'])->name('cart.coupons.delete');
    });
});

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place_an_order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');

Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');

Route::prefix('/wishlist')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
    Route::post('/move/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move');
    Route::delete('/remove/{rowId}', [WishlistController::class, 'remove_item'])->name('wishlist.item.remove');
    Route::delete('/empty', [WishlistController::class, 'empty_item'])->name('wishlist.empty');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');

        Route::prefix('orders')->group(function () {
            Route::get('/', [UserController::class, 'orders'])->name('user.orders');
            Route::get('/{order_id}/details', [UserController::class, 'orders_details'])->name('user.orders.details');
        });

        Route::get('/address', [UserController::class, 'address'])->name('user.address');
        Route::get('/details', [UserController::class, 'details'])->name('user.details');
        Route::get('/wishlist', [UserController::class, 'wishlist'])->name('user.wishlist');
    });
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        Route::prefix('brands')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.brands');
            Route::get('/add', [BrandController::class, 'create'])->name('admin.brand.add')->middleware('can:create,App\Models\Brand');
            Route::post('/store', [BrandController::class, 'store'])->name('admin.brand.store')->middleware('can:create,App\Models\Brand');
            Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit')->middleware('can:update,brand');
            Route::put('/{brand}/update', [BrandController::class, 'update'])->name('admin.brand.update');
            Route::delete('/{brand}/delete', [BrandController::class, 'delete'])->name('admin.brand.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories');
            Route::get('/add', [CategoryController::class, 'create'])->name('admin.categories.add')->middleware('can:create,App\Models\Category');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store')->middleware('can:create,App\Models\Category');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit')->middleware('can:update,category');
            Route::put('/{category}/update', [CategoryController::class, 'update'])->name('admin.categories.update');
            Route::delete('/{category}/delete', [CategoryController::class, 'delete'])->name('admin.categories.delete');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products');
            Route::get('/add', [ProductController::class, 'create'])->name('admin.products.add')->middleware('can:create,App\Models\Product');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store')->middleware('can:create,App\Models\Product');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit')->middleware('can:update,product');
            Route::put('{product}/update', [ProductController::class, 'update'])->name('admin.products.update');
            Route::delete('/{product}/delete', [ProductController::class, 'delete'])->name('admin.products.delete');
        });

        Route::prefix('coupons')->group(function () {
            Route::get('/', [AdminController::class, 'coupons'])->name('admin.coupons');
            Route::get('/add', [AdminController::class, 'add_coupons'])->name('admin.coupons.add')->middleware('can:create,App\Models\Coupon');
            Route::post('/store', [AdminController::class, 'store_coupons'])->name('admin.coupons.store')->middleware('can:create,App\Models\Coupon');
            Route::get('/{coupon}/edit', [AdminController::class, 'edit_coupons'])->name('admin.coupons.edit')->middleware('can:update,coupon');
            Route::put('/{coupon}/update', [AdminController::class, 'update_coupons'])->name('admin.coupons.update')->middleware('can:update,coupon');
            Route::delete('/{coupon}/delete', [AdminController::class, 'delete_coupons'])->name('admin.coupons.delete')->middleware('can:delete,coupon');
        });

        Route::prefix('slides')->group(function () {
            Route::get('/', [AdminController::class, 'slides'])->name('admin.slides');
            Route::get('/add', [AdminController::class, 'add_slides'])->name('admin.slides.add')->middleware('can:create,App\Models\Slide');
            Route::post('/store', [AdminController::class, 'store_slides'])->name('admin.slides.store')->middleware('can:create,App\Models\Slide');
            Route::get('/{slide}/edit', [AdminController::class, 'edit_slides'])->name('admin.slides.edit')->middleware('can:update,slide');
            Route::put('/{slide}/update', [AdminController::class, 'update_slides'])->name('admin.slides.update')->middleware('can:update,slide');
            Route::delete('/{slide}/delete', [AdminController::class, 'delete_slides'])->name('admin.slides.delete')->middleware('can:delete,slide');
        });

        Route::get('/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');

        Route::prefix('orders')->group(function () {
            Route::get('/', [AdminController::class, 'orders'])->name('admin.orders');
            Route::get('/{order}', [AdminController::class, 'orders_details'])->name('admin.orders.details')->middleware('can:view,order');
        });

        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });
});

require __DIR__ . '/auth.php';
