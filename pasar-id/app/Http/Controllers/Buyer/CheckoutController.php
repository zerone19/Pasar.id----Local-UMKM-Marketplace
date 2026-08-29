<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()])->load('items.product.store');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total = $cart->total();

        return view('marketplace.checkout', [
            'items' => $cart->items,
            'total' => $total,
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'address' => ['required', 'string', 'min:10'],
            'phone' => ['required', 'string', 'min:8'],
            'payment_method' => ['required', 'in:cod,transfer'],
            'notes' => ['nullable', 'string'],
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()])->load('items.product.store');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal = $cart->total();
        $shipping = 0; // MVP: COD/transfer tanpa ongkir otomatis
        $total = $subtotal + $shipping;

        // Simpan per toko (satu order per toko di keranjang)
        $orders = [];
        foreach ($cart->items->groupBy('product.store_id') as $storeId => $items) {
            $orderSubtotal = $items->sum(fn ($i) => $i->price * $i->quantity);
            $order = Order::create([
                'buyer_id' => auth()->id(),
                'store_id' => $storeId,
                'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
                'address' => $request->address,
                'phone' => $request->phone,
                'subtotal' => $orderSubtotal,
                'shipping_cost' => 0,
                'total' => $orderSubtotal + $shipping,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
                'order_status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'store_id' => $storeId,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
                'amount' => $order->total,
            ]);

            $orders[] = $order;
        }

        // kosongkan keranjang
        $cart->items()->delete();

        if (count($orders) === 1) {
            return redirect()->route('orders.show', $orders[0])
                ->with('success', 'Pesanan berhasil dibuat.');
        }

        return redirect()->route('orders.index')
            ->with('success', count($orders) . ' pesanan berhasil dibuat.');
    }
}
