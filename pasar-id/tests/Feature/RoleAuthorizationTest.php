<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_cannot_access_seller_dashboard(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->actingAs($buyer)
            ->get('/seller/dashboard')
            ->assertForbidden();
    }

    public function test_buyer_cannot_access_admin_dashboard(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->actingAs($buyer)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_seller_can_access_seller_dashboard(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);

        $this->actingAs($seller)
            ->get('/seller/dashboard')
            ->assertOk();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect(route('login'));
    }
}
