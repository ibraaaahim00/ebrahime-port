<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Experience;
use App\Models\PortfolioPillar;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\Skill;

class PortfolioQueryService
{
    /**
     * @return array<string, mixed>
     */
    public function home(): array
    {
        $sections = Section::query()->where('active', true)->orderBy('sort_order')->get()->keyBy('key');
        $skills = Skill::query()->where('active', true)->orderBy('sort_order')->get();

        return [
            'profile' => PortfolioProfile::query()->firstOrFail(),
            'settings' => SiteSetting::query()->get()->mapWithKeys(fn (SiteSetting $setting): array => [$setting->key => $setting->typedValue()])->all(),
            'sections' => $sections,
            'hero' => $sections->get('hero'),
            'about' => $sections->get('about'),
            'skillsSection' => $sections->get('skills'),
            'projectsSection' => $sections->get('projects'),
            'experienceSection' => $sections->get('experience'),
            'githubSection' => $sections->get('github'),
            'resumeSection' => $sections->get('resume'),
            'contactSection' => $sections->get('contact'),
            'pillars' => PortfolioPillar::query()->where('active', true)->orderBy('sort_order')->get(),
            'skills' => $skills,
            'skillsByCategory' => $skills->groupBy('category'),
            'categories' => Category::query()->where('active', true)->orderBy('sort_order')->get(),
            'projects' => Project::query()->visible()->with(['category', 'technologies'])->orderBy('sort_order')->get(),
            'githubProjects' => Project::query()->visible()->whereNotNull('github_url')->with('technologies')->orderBy('sort_order')->get(),
            'experiences' => Experience::query()->where('active', true)->orderBy('sort_order')->get(),
        ];
    }
}
