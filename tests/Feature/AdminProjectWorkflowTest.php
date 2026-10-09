<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProjectWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_publish_and_feature_a_project(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::query()->where('is_admin', true)->firstOrFail();
        $category = Category::query()->firstOrFail();
        $technology = Technology::query()->firstOrFail();
        $payload = ['title' => 'CMS Workflow', 'slug' => '', 'category_id' => $category->id, 'short_description' => 'A CMS workflow project.', 'full_description' => 'A full project description.', 'github_url' => 'https://github.com/example/cms-workflow', 'live_demo_url' => '', 'project_status' => 'completed', 'sort_order' => 20, 'technology_ids' => [$technology->id], 'featured' => '1', 'published' => '1', 'active' => '1'];

        $response = $this->actingAs($admin)->post(route('admin.projects.store'), $payload);
        $project = Project::query()->where('title', 'CMS Workflow')->firstOrFail();

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertSame('cms-workflow', $project->slug);
        $this->assertTrue($project->featured);
        $this->assertTrue($project->technologies->contains($technology));

        $this->actingAs($admin)->put(route('admin.projects.update', $project), array_merge($payload, ['slug' => 'cms-workflow', 'live_demo_url' => 'https://technova-eg.great-site.net/']))->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['slug' => 'cms-workflow', 'live_demo_url' => 'https://technova-eg.great-site.net/']);

        $this->actingAs($admin)->post(route('admin.projects.toggle', [$project, 'published']))->assertRedirect();
        $this->get(route('home'))->assertDontSee('CMS Workflow');
        $this->actingAs($admin)->post(route('admin.projects.toggle', [$project, 'published']))->assertRedirect();
        $this->get(route('home'))->assertSee('CMS Workflow');
        $this->actingAs($admin)->put(route('admin.projects.update', $project), array_merge($payload, ['title' => 'CMS Workflow Updated', 'slug' => 'cms-workflow-updated']))->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['slug' => 'cms-workflow-updated', 'title' => 'CMS Workflow Updated']);
        $this->actingAs($admin)->post(route('admin.projects.toggle', [$project->refresh(), 'active']))->assertRedirect();
        $this->get(route('home'))->assertDontSee('CMS Workflow Updated');
        $this->actingAs($admin)->delete(route('admin.projects.destroy', $project->refresh()))->assertRedirect();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
