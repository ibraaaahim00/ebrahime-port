<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_projects_are_rendered_from_the_database(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('home'));

        $response->assertOk()->assertSee('DentCare')->assertSee('https://github.com/ibraaaahim00/dentcare')->assertSee('Awfar')->assertSee('CivicFix')->assertSee('Clinic Booking')->assertSee('ALAMAAL')->assertSee('Ezhal');
        $this->assertDatabaseCount('projects', 6);
    }

    public function test_project_details_use_the_database_slug_and_hide_missing_live_demo(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('projects.show', 'dentcare'));

        $response->assertOk()->assertSee('Dental Clinic Management System')->assertSee('https://github.com/ibraaaahim00/dentcare')->assertDontSee('Live Demo');
    }

    public function test_portfolio_and_admin_support_arabic_locale_with_rtl_layout(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get(route('locale.switch', ['locale' => 'ar']))->assertRedirect();

        $this->get(route('home'))->assertOk()->assertSee('lang="ar"', false)->assertSee('dir="rtl"', false)->assertSee('تواصل معي')->assertSee('المهارات والتقنيات')->assertSee('نظام إدارة عيادة أسنان')->assertSee('معمارية نظيفة');
        $this->get(route('projects.show', 'dentcare'))->assertOk()->assertSee('نظام إدارة عيادة أسنان')->assertSee('لوحة CMS')->assertSee('dir="rtl"', false);
        $admin = User::query()->where('is_admin', true)->firstOrFail();
        $this->actingAs($admin)->get(route('admin.skills.index'))->assertOk()->assertSee('dir="rtl"', false)->assertSee('إدارة البورتفوليو');
    }
}
