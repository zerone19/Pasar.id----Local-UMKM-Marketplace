<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->first();

        $status = $request->input('status');
        $search = $request->input('search');

        $orders = $store
            ? Order::where('store_id', $store->id)
                ->when($status && $status !== 'all', fn ($q) => $q->where('order_status', $status))
                ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhereHas('buyer', fn ($b) => $b->where('name', 'like', "%{$search}%"));
                }))
                ->latest()
                ->with('buyer', 'items')
                ->paginate(15)
                ->withQueryString()
            : collect();

        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'completed', 'cancelled'];

        return view('seller.orders', compact('orders', 'store', 'statuses', 'status', 'search'));
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
