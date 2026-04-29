<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_redirects_to_role_selection(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
        $response->assertSee('Daftar sebagai Pencari Kos');
        $response->assertSee('Daftar sebagai Pemilik Kos');
    }

    public function test_user_registration_creates_user_role(): void
    {
        $response = $this->post(route('register.user.store'), [
            'name' => 'User Test',
            'email' => 'user@example.com',
            'no_hp' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
            'role' => 'user',
        ]);
    }

    public function test_owner_registration_creates_owner_role(): void
    {
        $response = $this->post(route('register.owner.store'), [
            'name' => 'Owner Test',
            'email' => 'owner@example.com',
            'no_hp' => '081234567891',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login', ['role' => 'owner']));
        $this->assertDatabaseHas('users', [
            'email' => 'owner@example.com',
            'role' => 'owner',
            'status_verifikasi_identitas' => 'belum',
        ]);
    }

    public function test_login_redirects_user_based_on_actual_role(): void
    {
        $user = User::factory()->create([
            'email' => 'user@login.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $owner = User::factory()->create([
            'email' => 'owner@login.test',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $admin = User::factory()->create([
            'email' => 'admin@login.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('home'));

        $this->post(route('logout'));

        $this->post(route('login'), [
            'email' => $owner->email,
            'password' => 'password',
        ])->assertRedirect(route('owner.dashboard'));

        $this->post(route('logout'));

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_google_login_route_is_restricted_for_non_user_roles(): void
    {
        $response = $this->get(route('auth.google.redirect', ['role' => 'owner']));

        $response->assertRedirect(route('login', ['role' => 'owner']));
        $response->assertSessionHasErrors('login');
    }
}
