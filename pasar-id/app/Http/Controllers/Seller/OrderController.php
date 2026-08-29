<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->first();

        $orders = $store
            ? Order::where('store_id', $store->id)->latest()->with('buyer', 'items')->paginate(15)
            : collect();

        return view('seller.orders', compact('orders', 'store'));
    }

    public function show(Order $order): View
    {
        abort_if($order->store->user_id !== auth()->id(), 403);

        $order->load('items.product', 'buyer', 'payment');

        return view('seller.order', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        abort_if($order->store->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'order_status' => ['required', 'in:confirmed,processing,shipped,completed,cancelled'],
        ]);

        $order->update($validated);

        // kalau selesai & transfer, tandai paid
        if ($validated['order_status'] === 'completed' && $order->payment_method === 'transfer') {
            $order->payment()->update(['status' => 'paid']);
            $order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
