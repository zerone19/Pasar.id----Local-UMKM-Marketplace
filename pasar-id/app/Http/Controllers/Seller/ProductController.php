<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $store = Store::where('user_id', auth()->id())->first();

        $products = $store
            ? $store->products()->latest()->paginate(12)
            : collect();

        return view('seller.products', compact('products', 'store'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('seller.product-create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $store = Store::where('user_id', auth()->id())->first();

        if (! $store || $store->status !== 'active') {
            return redirect()->route('seller.store.edit')
                ->with('error', 'Anda harus punya toko aktif untuk menambah produk.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
        ]);

        Product::create([
            'store_id' => $store->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name'] . '-' . $store->id . '-' . time()),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'weight' => $validated['weight'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('seller.products')
            ->with('success', 'Produk ditambahkan.');
    }

    public function edit(Product $product): View
    {
        abort_if($product->store->user_id !== auth()->id(), 403);

        $categories = Category::orderBy('name')->get();

        return view('seller.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_if($product->store->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,active,inactive,out_of_stock'],
        ]);

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'weight' => $validated['weight'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('seller.products')
            ->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_if($product->store->user_id !== auth()->id(), 403);

        $product->delete();

        return redirect()->route('seller.products')
            ->with('success', 'Produk dihapus.');
    }
}
