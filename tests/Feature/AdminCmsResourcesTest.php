<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\PortfolioService;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCmsResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_cms_content_and_updates_reach_the_frontend(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::query()->where('is_admin', true)->firstOrFail();

        $this->actingAs($admin)->post(route('admin.skills.store'), [
            'name' => 'CMS Testing',
            'category' => 'Testing',
            'category_label' => 'Testing',
            'level' => 'Advanced',
            'tag' => 'Testing',
            'sort_order' => 99,
            'active' => '1',
        ])->assertRedirect(route('admin.skills.index'));
        $this->assertDatabaseHas('skills', ['name' => 'CMS Testing']);
        $this->get(route('home'))->assertSee('CMS Testing');

        $this->actingAs($admin)->post(route('admin.experiences.store'), [
            'company' => 'CMS Company',
            'position' => 'Backend Engineer',
            'description' => 'CMS experience.',
            'start_date' => '2024-01-01',
            'end_date' => '',
            'current' => '1',
            'location' => 'Remote',
            'technologies' => '["Laravel"]',
            'highlights' => '["Delivered CMS"]',
            'sort_order' => 99,
            'active' => '1',
        ])->assertRedirect(route('admin.experiences.index'));
        $this->assertDatabaseHas('experiences', ['company' => 'CMS Company']);
        $this->get(route('home'))->assertSee('CMS Company');

        $this->actingAs($admin)->post(route('admin.education.store'), [
            'institution' => 'CMS University',
            'degree' => 'Bachelor',
            'field' => 'Computer Science',
            'description' => 'CMS education.',
            'start_date' => '2020-01-01',
            'end_date' => '2024-01-01',
            'location' => 'Cairo',
            'sort_order' => 99,
            'active' => '1',
        ])->assertRedirect(route('admin.education.index'));
        $this->assertDatabaseHas('education', ['institution' => 'CMS University']);

        $this->actingAs($admin)->post(route('admin.services.store'), [
            'title' => 'CMS Service',
            'description' => 'CMS service description.',
            'icon' => 'code',
            'sort_order' => 99,
            'active' => '1',
        ])->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('portfolio_services', ['title' => 'CMS Service']);

        $this->actingAs($admin)->post(route('admin.testimonials.store'), [
            'name' => 'CMS Client',
            'position' => 'Founder',
            'company' => 'CMS Company',
            'testimonial' => 'Excellent CMS work.',
            'rating' => 5,
            'sort_order' => 99,
            'active' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['name' => 'CMS Client']);

        $this->actingAs($admin)->put(route('admin.profile.update'), [
            'name' => 'Updated Portfolio Name',
            'professional_title' => 'Updated Title',
            'short_bio' => 'Updated short bio.',
            'available' => '1',
            'years_of_experience' => 8,
        ])->assertRedirect();
        $this->assertDatabaseHas('portfolio_profiles', ['name' => 'Updated Portfolio Name']);
        $this->get(route('home'))->assertSee('Updated Portfolio Name')->assertSee('Updated Title');

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'settings' => ['footer_text' => 'Updated footer content'],
        ])->assertRedirect();
        $this->assertDatabaseHas('site_settings', ['key' => 'footer_text', 'value' => 'Updated footer content']);
        $this->assertSame('Updated footer content', data_get(SiteSetting::query()->where('key', 'footer_text')->firstOrFail()->translations, 'ar.value'));
        $this->get(route('home'))->assertSee('Updated footer content');
        app()->setLocale('ar');
        $this->get(route('home'))->assertSee('Updated footer content');

        $section = Section::query()->where('key', 'skills')->firstOrFail();
        $this->actingAs($admin)->post(route('admin.sections.toggle', $section))->assertRedirect();
        $this->get(route('home'))->assertDontSee('CMS Testing');
        $this->actingAs($admin)->post(route('admin.sections.toggle', $section->refresh()))->assertRedirect();
        $this->get(route('home'))->assertSee('CMS Testing');

        $this->assertInstanceOf(PortfolioProfile::class, PortfolioProfile::query()->first());
        $this->assertSame(1, Experience::query()->where('company', 'CMS Company')->count());
        $this->assertSame(1, Education::query()->where('institution', 'CMS University')->count());
        $this->assertSame(1, PortfolioService::query()->where('title', 'CMS Service')->count());
        $this->assertSame(1, Testimonial::query()->where('name', 'CMS Client')->count());
        $this->assertInstanceOf(Skill::class, Skill::query()->where('name', 'CMS Testing')->first());
        $this->assertInstanceOf(SiteSetting::class, SiteSetting::query()->where('key', 'footer_text')->first());
    }
}
