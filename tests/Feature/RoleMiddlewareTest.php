<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_role_can_access_only_its_dashboard(): void
    {
        foreach (['admin', 'dokter', 'pasien'] as $role) {
            $user = User::factory()->create(['role' => $role]);
            $this->actingAs($user)
                ->get(route($role.'.dashboard'))
                ->assertOk();
            auth()->logout();
        }
    }

    public function test_a_user_with_the_wrong_role_is_forbidden(): void
    {
        $user = User::factory()->create(['role' => 'pasien']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_only_patients_can_access_patient_registration(): void
    {
        $user = User::factory()->create(['role' => 'dokter']);

        $this->actingAs($user)
            ->get(route('pasien.daftar-poli.index'))
            ->assertForbidden();
    }
}
