<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('buyer', 'store')
            ->latest()
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product', 'buyer', 'store', 'payment');

        return view('admin.order-show', compact('order'));
    }
}
