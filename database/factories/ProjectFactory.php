<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'slug' => fake()->unique()->slug(),
            'short_description' => fake()->sentence(),
            'full_description' => fake()->paragraph(),
            'github_url' => 'https://github.com/example/project',
            'live_demo_url' => null,
            'project_status' => 'completed',
            'featured' => false,
            'published' => true,
            'active' => true,
            'sort_order' => fake()->numberBetween(0, 20),
            'case_study' => [],
        ];
    }
}
