<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_update_account_credentials_from_the_dashboard(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::query()->where('is_admin', true)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.account.edit'))
            ->assertOk()
            ->assertSee('Account Settings');

        $this->actingAs($admin)->put(route('admin.account.update'), [
            'name' => 'Updated Administrator',
            'email' => 'owner@example.com',
            'current_password' => 'password',
            'new_password' => 'A secure password 2026!',
            'new_password_confirmation' => 'A secure password 2026!',
        ])->assertRedirect();

        $admin->refresh();
        $this->assertSame('Updated Administrator', $admin->name);
        $this->assertSame('owner@example.com', $admin->email);
        $this->assertTrue(Hash::check('A secure password 2026!', $admin->password));

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.store'), [
            'email' => 'owner@example.com',
            'password' => 'A secure password 2026!',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_account_updates_require_the_current_password_and_admin_access(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::query()->where('is_admin', true)->firstOrFail();
        $regularUser = User::factory()->create();

        $this->get(route('admin.account.edit'))->assertRedirect(route('login'));
        $this->actingAs($regularUser)->get(route('admin.account.edit'))->assertForbidden();

        $this->actingAs($admin)->put(route('admin.account.update'), [
            'name' => 'Should Not Save',
            'email' => 'should-not-save@example.com',
            'current_password' => 'wrong-password',
        ])->assertSessionHasErrors('current_password');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => 'admin@example.com',
        ]);
    }

    public function test_the_database_seeder_does_not_reset_an_existing_admin_account(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::query()->where('is_admin', true)->firstOrFail();
        $admin->update([
            'email' => 'custom@example.com',
            'password' => 'A secure password 2026!',
        ]);

        $this->seed(DatabaseSeeder::class);

        $admin->refresh();
        $this->assertSame('custom@example.com', $admin->email);
        $this->assertTrue(Hash::check('A secure password 2026!', $admin->password));
    }
}
