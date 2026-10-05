<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_is_validated_and_stored(): void
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->post(route('contact.store'), ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'phone' => '+201000000000', 'subject' => 'Backend project', 'message' => 'I would like to discuss a project with you.', 'website' => '']);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', ['email' => 'jane@example.com', 'status' => 'unread']);
    }

    public function test_admin_routes_are_restricted_and_messages_can_be_moderated(): void
    {
        $this->seed(DatabaseSeeder::class);
        $message = ContactMessage::factory()->create();
        $admin = User::query()->where('is_admin', true)->firstOrFail();
        $regularUser = User::factory()->create();

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->actingAs($regularUser)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Unread Messages');
        $this->actingAs($admin)->get(route('admin.categories.index'))->assertOk()->assertSee('Categories');
        $this->actingAs($admin)->get(route('admin.technologies.create'))->assertOk()->assertSee('Technologies');
        $this->actingAs($admin)->post(route('admin.messages.read', $message))->assertRedirect();
        $this->assertNotNull($message->refresh()->read_at);
        $this->actingAs($admin)->post(route('admin.messages.archive', $message))->assertRedirect();
        $this->assertSame('archived', $message->refresh()->status);
        $this->actingAs($admin)->delete(route('admin.messages.destroy', $message))->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_log_in_through_the_session_authentication_flow(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
        $this->get(route('admin.dashboard'))->assertOk();
    }
}
