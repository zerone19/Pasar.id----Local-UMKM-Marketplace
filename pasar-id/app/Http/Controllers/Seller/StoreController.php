<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function edit(): View
    {
        $store = Store::where('user_id', auth()->id())->firstOrNew(['user_id' => auth()->id()]);

        return view('seller.store-edit', compact('store'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'banner' => ['nullable', 'image', 'max:4096'],
        ]);

        $store = Store::where('user_id', auth()->id())->firstOrNew(['user_id' => auth()->id()]);
        $store->fill($validated);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($store->exists && $store->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($store->logo);
            }
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->logo = $logoPath;
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            if ($store->exists && $store->banner) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($store->banner);
            }
            $bannerPath = $request->file('banner')->store('stores/banners', 'public');
            $store->banner = $bannerPath;
        }

        if ($store->exists) {
            $isNew = false;
        } else {
            $store->slug = \Illuminate\Support\Str::slug($validated['store_name'] . '-' . auth()->id());
            $store->status = 'pending'; // menunggu persetujuan admin
            $isNew = true;
        }

        $store->save();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Toko disimpan. Menunggu persetujuan admin.');
    }
}
