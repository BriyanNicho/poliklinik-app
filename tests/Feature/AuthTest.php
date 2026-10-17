<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_register_as_a_patient(): void
    {
        $response = $this->post(route('register.store'), [
            'nama' => 'Siti Pasien',
            'alamat' => 'Jl. Sehat No. 1',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
            'email' => 'siti@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'nama' => 'Siti Pasien',
            'alamat' => 'Jl. Sehat No. 1',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
            'email' => 'siti@example.com',
            'role' => 'pasien',
        ]);
        $this->assertMatchesRegularExpression(
            '/^\d{6}-\d{3}$/',
            User::firstOrFail()->no_rm
        );
        $this->assertTrue(Hash::check('Password123!', User::first()->password));
    }

    public function test_a_registered_user_can_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'siti@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('pasien.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'siti@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password-salah',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_a_user_can_log_out(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
