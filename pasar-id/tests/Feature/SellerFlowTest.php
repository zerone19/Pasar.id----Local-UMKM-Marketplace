<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_create_store_and_product(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);

        // buat toko
        $this->actingAs($seller)
            ->post(route('seller.store.update'), [
                'store_name' => 'Toko Seller',
                'city' => 'Bandung',
            ])
            ->assertRedirect(route('seller.dashboard'));

        $store = Store::where('user_id', $seller->id)->first();
        $this->assertNotNull($store);

        // aktivasi manual (simulasi admin approve) biar bisa add produk
        $store->update(['status' => 'active']);

        $category = Category::create(['name' => 'Test', 'slug' => 'test']);

        // tambah produk
        $this->actingAs($seller)
            ->post(route('seller.products.store'), [
                'name' => 'Produk Seller',
                'category_id' => $category->id,
                'price' => 30000,
                'stock' => 5,
            ])
            ->assertRedirect(route('seller.products'));

        $this->assertDatabaseHas('products', [
            'store_id' => $store->id,
            'name' => 'Produk Seller',
            'status' => 'active',
        ]);

        // halaman produk seller OK
        $product = Product::where('store_id', $store->id)->first();
        $this->actingAs($seller)
            ->get(route('seller.products.edit', $product))
            ->assertOk();
    }

    public function test_buyer_cannot_access_seller_area(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->actingAs($buyer)
            ->get(route('seller.products'))
            ->assertForbidden();
    }
}
