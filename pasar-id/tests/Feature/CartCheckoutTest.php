<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_add_to_cart_checkout_and_see_order(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $store = Store::create([
            'user_id' => $seller->id,
            'store_name' => 'Toko Test',
            'slug' => 'toko-test',
            'status' => 'active',
        ]);
        $product = Product::create([
            'store_id' => $store->id,
            'name' => 'Produk Test',
            'slug' => 'produk-test',
            'price' => 50000,
            'stock' => 10,
            'status' => 'active',
        ]);

        $buyer = User::factory()->create(['role' => 'buyer']);

        // add to cart
        $this->actingAs($buyer)
            ->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 2])
            ->assertRedirect(route('cart.index'));

        // cart shows item
        $this->actingAs($buyer)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Produk Test');

        // checkout
        $this->actingAs($buyer)
            ->post(route('checkout.store'), [
                'address' => 'Jl. Contoh No. 1',
                'phone' => '08123456789',
                'payment_method' => 'cod',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', ['buyer_id' => $buyer->id, 'order_status' => 'pending']);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 2]);

        // stock decremented
        $this->assertEquals(8, $product->fresh()->stock);

        // order list visible
        $this->actingAs($buyer)
            ->get(route('orders.index'))
            ->assertOk();
    }
}
