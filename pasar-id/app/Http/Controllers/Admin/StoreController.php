<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = Store::with('user')->latest()->paginate(20);

        return view('admin.sellers', compact('stores'));
    }

    public function show(Store $store): View
    {
        $store->load('user', 'products');

        return view('admin.store-show', compact('store'));
    }

    public function approve(Store $store): RedirectResponse
    {
        $store->update(['status' => 'active']);

        return back()->with('success', 'Toko disetujui.');
    }

    public function reject(Store $store): RedirectResponse
    {
        $store->update(['status' => 'rejected']);

        return back()->with('success', 'Toko ditolak.');
    }

    public function suspend(Store $store): RedirectResponse
    {
        $store->update(['status' => 'suspended']);

        return back()->with('success', 'Toko ditangguhkan.');
    }
}
