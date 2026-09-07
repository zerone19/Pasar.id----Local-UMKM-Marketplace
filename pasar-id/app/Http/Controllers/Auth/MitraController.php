<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class MitraController extends Controller
{
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('auth.mitra', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'store_name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'seller',
        ]);

        // Buat toko draft otomatis agar seller langsung punya etalase
        Store::create([
            'user_id' => $user->id,
            'store_name' => $validated['store_name'],
            'slug' => \Illuminate\Support\Str::slug($validated['store_name'].'-'.$user->id),
            'category_id' => $validated['category_id'] ?? null,
            'status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('seller.dashboard', absolute: false));
    }
}
