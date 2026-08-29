<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('store', 'items')
            ->where('buyer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('marketplace.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_if($order->buyer_id !== auth()->id(), 403);

        $order->load('items.product', 'store', 'payment');

        return view('marketplace.order', compact('order'));
    }
}
