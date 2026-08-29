<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private function cart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index(): View
    {
        $cart = $this->cart()->load('items.product.store');

        return view('marketplace.cart', [
            'items' => $cart->items,
            'total' => $cart->total(),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'active' || $product->stock <= 0) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = $this->cart();
        $qty = (int) $request->input('quantity', 1);

        $item = $cart->items()->where('product_id', $product->id)->first();

        $newQty = $item ? $item->quantity + $qty : $qty;
        if ($newQty > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia (' . $product->stock . ').');
        }

        if ($item) {
            $item->increment('quantity', $qty);
            $item->update(['price' => $product->price]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_if($cartItem->cart->user_id !== auth()->id(), 403);

        $request->validate(['quantity' => ['integer', 'min:1', 'max:99']]);

        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $cartItem->product->price,
        ]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        abort_if($cartItem->cart->user_id !== auth()->id(), 403);

        $cartItem->delete();

        return back()->with('success', 'Item dihapus.');
    }
}
