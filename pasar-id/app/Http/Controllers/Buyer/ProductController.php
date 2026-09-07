<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Homepage: featured + latest products + categories + popular stores
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category'])
            ->where('status', 'active')
            ->where('stock', '>', 0);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $featured = Product::with('store')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        $stores = Store::where('status', 'active')
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();

        return view('marketplace.index', compact('products', 'categories', 'featured', 'stores'));
    }

    // All categories
    public function categories()
    {
        $categories = Category::withCount(['products' => function ($query) {
                $query->where('status', 'active')->where('stock', '>', 0);
            }])
            ->orderBy('name')
            ->get();

        return view('marketplace.categories', compact('categories'));
    }

    // Product detail
    public function show(Product $product)
    {
        if ($product->status !== 'active' || $product->stock <= 0) {
            abort(404);
        }

        $product->load(['store', 'category', 'images']);

        return view('marketplace.product', compact('product'));
    }

    // Category listing
    public function byCategory(Category $category)
    {
        $products = $category->products()
            ->with('store')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('marketplace.category', compact('category', 'products'));
    }

    // Store detail
    public function byStore(Store $store)
    {
        if ($store->status !== 'active') {
            abort(404);
        }

        $products = $store->products()
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('marketplace.store', compact('store', 'products'));
    }
}
