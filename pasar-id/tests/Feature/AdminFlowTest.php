<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_and_approve_store(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);
        $store = Store::create([
            'user_id' => $seller->id,
            'store_name' => 'Toko Pending',
            'slug' => 'toko-pending',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.sellers'))
            ->assertOk()
            ->assertSee('Toko Pending');

        $this->actingAs($admin)
            ->post(route('admin.sellers.approve', $store))
            ->assertRedirect();

        $this->assertEquals('active', $store->fresh()->status);
    }

    public function test_seller_cannot_access_admin_area(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);

        $this->actingAs($seller)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Oleh-oleh',
                'description' => 'Kategori oleh-oleh',
            ])
            ->assertRedirect(route('admin.categories'));

        $this->assertDatabaseHas('categories', ['name' => 'Oleh-oleh']);
    }
}
