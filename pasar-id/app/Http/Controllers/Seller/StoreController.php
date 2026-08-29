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
        ]);

        $store = Store::updateOrCreate(
            ['user_id' => auth()->id()],
            array_merge($validated, [
                'slug' => \Illuminate\Support\Str::slug($validated['store_name'] . '-' . auth()->id()),
                'status' => 'pending', // menunggu persetujuan admin
            ])
        );

        return redirect()->route('seller.dashboard')
            ->with('success', 'Toko disimpan. Menunggu persetujuan admin.');
    }
}
