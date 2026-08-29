<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('store', 'category')
            ->latest()
            ->paginate(20);

        return view('admin.products', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load('store', 'category', 'images');

        return view('admin.product-show', compact('product'));
    }

    public function setStatus(Product $product, string $status): RedirectResponse
    {
        abort_if(! in_array($status, ['draft', 'active', 'inactive', 'out_of_stock']), 404);

        $product->update(['status' => $status]);

        return back()->with('success', 'Status produk: ' . $status);
    }
}
