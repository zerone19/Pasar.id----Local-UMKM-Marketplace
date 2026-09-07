<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Buyer\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Auth\MitraController;
use Illuminate\Support\Facades\Route;

// Marketplace public routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/categories', [ProductController::class, 'categories'])->name('categories.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [ProductController::class, 'byCategory'])->name('categories.show');
Route::get('/stores/{store}', [ProductController::class, 'byStore'])->name('stores.show');

// Mitra UMKM (seller) registration — split-screen branded page
Route::middleware('guest')->group(function () {
    Route::get('/mitra', [MitraController::class, 'create'])->name('mitra.create');
    Route::post('/mitra', [MitraController::class, 'store'])->name('mitra.store');
});

Route::get('/', function () {
    return app(ProductController::class)->index(request());
});

Route::get('/dashboard', function () {
    $role = auth()->user()?->role;

    return match ($role) {
        'seller' => redirect()->route('seller.dashboard'),
        'admin'  => redirect()->route('admin.dashboard'),
        default  => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Buyer: cart, checkout, orders
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
});

// Seller area
Route::middleware(['auth', 'verified', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');

    Route::get('/seller/store', [StoreController::class, 'edit'])->name('seller.store.edit');
    Route::post('/seller/store', [StoreController::class, 'update'])->name('seller.store.update');

    Route::get('/seller/products', [SellerProductController::class, 'index'])->name('seller.products');
    Route::get('/seller/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products', [SellerProductController::class, 'store'])->name('seller.products.store');
    Route::get('/seller/products/{product}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    Route::patch('/seller/products/{product}', [SellerProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/seller/products/{product}', [SellerProductController::class, 'destroy'])->name('seller.products.destroy');

    Route::get('/seller/orders', [SellerOrderController::class, 'index'])->name('seller.orders');
    Route::get('/seller/orders/{order}', [SellerOrderController::class, 'show'])->name('seller.orders.show');
    Route::patch('/seller/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.status');
});

// Admin area
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');

    Route::get('/admin/sellers', [AdminStoreController::class, 'index'])->name('admin.sellers');
    Route::get('/admin/sellers/{store}', [AdminStoreController::class, 'show'])->name('admin.sellers.show');
    Route::post('/admin/sellers/{store}/approve', [AdminStoreController::class, 'approve'])->name('admin.sellers.approve');
    Route::post('/admin/sellers/{store}/reject', [AdminStoreController::class, 'reject'])->name('admin.sellers.reject');
    Route::post('/admin/sellers/{store}/suspend', [AdminStoreController::class, 'suspend'])->name('admin.sellers.suspend');

    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::patch('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::post('/admin/products/{product}/{status}', [AdminProductController::class, 'setStatus'])->name('admin.products.status');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
