<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalSellers' => User::where('role', 'seller')->count(),
            'totalStores' => Store::count(),
            'pendingStores' => Store::where('status', 'pending')->count(),
            'totalProducts' => Product::count(),
            'pendingProducts' => Product::where('status', 'draft')->count(),
            'totalOrders' => Order::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ]);
    }
}
