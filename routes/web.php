<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop/{product_slug}', [HomeController::class, 'products_detail'])->name('shop.product.details');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/contact/store', [HomeController::class, 'store_contact'])->name('contact.store');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'products_detail'])->name('shop.product.details');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/empty', [CartController::class, 'empty_cart'])->name('cart.empty');

Route::post('/cart/coupons', [CartController::class, 'apply_coupons_code'])->name('cart.coupons');
Route::delete('/cart/coupons/remove', [CartController::class, 'remove_coupon_code'])->name('cart.coupons.delete');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place_an_order', [CartController::class, 'place_an_order'])->name('cart.place.order');

Route::get('/order_confirmation', [CartController::class, 'order_confirmation'])->name('cart.confirm');


Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::post('/wishlist/move/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move');
Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/empty', [WishlistController::class, 'empty_item'])->name('wishlist.empty');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'store_brand'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'edit_brand'])->name('admin.brand.edit');
    Route::put('/admin/brand/update/{id}', [AdminController::class, 'update_brand'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'delete_brand'])->name('admin.brand.delete');

    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/categories/add', [AdminController::class, 'add_categories'])->name('admin.categories.add');
    Route::post('/admin/categories/store', [AdminController::class, 'store_categories'])->name('admin.categories.store');
    Route::get('/admin/categories/edit/{id}', [AdminController::class, 'edit_categories'])->name('admin.categories.edit');
    Route::put('/admin/categories/update/{id}', [AdminController::class, 'update_categories'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}/delete', [AdminController::class, 'delete_categories'])->name('admin.categories.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/add', [AdminController::class, 'add_products'])->name('admin.products.add');
    Route::post('/admin/products/store', [AdminController::class, 'store_products'])->name('admin.products.store');
    Route::get('/admin/products/edit/{id}', [AdminController::class, 'edit_products'])->name('admin.products.edit');
    Route::put('/admin/products/update/{id}', [AdminController::class, 'update_products'])->name('admin.products.update');
    Route::delete('/admin/products/{id}/delete', [AdminController::class, 'delete_products'])->name('admin.products.delete');

    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupons/add', [AdminController::class, 'add_coupons'])->name('admin.coupons.add');
    Route::post('/admin/coupons/store', [AdminController::class, 'store_coupons'])->name('admin.coupons.store');
    Route::get('/admin/coupons/edit/{id}', [AdminController::class, 'edit_coupons'])->name('admin.coupons.edit');
    Route::put('/admin/coupons/update/{id}', [AdminController::class, 'update_coupons'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/{id}/delete', [AdminController::class, 'delete_coupons'])->name('admin.coupons.delete');

    Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
    Route::get('/admin/slides/add', [AdminController::class, 'add_slides'])->name('admin.slides.add');
    Route::post('/admin/slides/store', [AdminController::class, 'store_slides'])->name('admin.slides.store');
    Route::get('/admin/slides/edit/{id}', [AdminController::class, 'edit_slides'])->name('admin.slides.edit');
    Route::put('/admin/slides/update/{id}', [AdminController::class, 'update_slides'])->name('admin.slides.update');
    Route::delete('/admin/slides/{id}/delete', [AdminController::class, 'delete_slides'])->name('admin.slides.delete');

    Route::get('/admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
});

require __DIR__ . '/auth.php';
