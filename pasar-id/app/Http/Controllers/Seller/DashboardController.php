<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $store = Store::where('user_id', auth()->id())->first();

        if (! $store) {
            return view('seller.no-store');
        }

        $productsQuery = $store->products();
        $ordersQuery = Order::where('store_id', $store->id);

        return view('seller.dashboard', [
            'store' => $store,
            'totalProducts' => (clone $productsQuery)->count(),
            'activeProducts' => (clone $productsQuery)->where('status', 'active')->count(),
            'totalOrders' => (clone $ordersQuery)->count(),
            'pendingOrders' => (clone $ordersQuery)->where('order_status', 'pending')->count(),
            'revenue' => (clone $ordersQuery)->where('payment_status', 'paid')->sum('total'),
            'recentOrders' => (clone $ordersQuery)->latest()->take(5)->with('buyer')->get(),
        ]);
    }
}
