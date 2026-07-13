<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_active_administrator_can_log_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('rahasia-aman'),
        ]);

        $response = $this->post(route('login.post'), [
            'login' => (string) $user->id,
            'password' => 'rahasia-aman',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_an_active_administrator_can_log_in_with_email(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('rahasia-email'),
        ]);

        $response = $this->post(route('login.post'), [
            'login' => $user->email,
            'password' => 'rahasia-email',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_non_administrator_cannot_open_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
