<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;

class DashboardService
{
    /**
     * @return array<string, int>
     */
    public function metrics(): array
    {
        return [
            'total_projects' => Project::query()->count(),
            'published_projects' => Project::query()->where('published', true)->count(),
            'featured_projects' => Project::query()->where('featured', true)->count(),
            'total_skills' => Skill::query()->count(),
            'experiences' => Experience::query()->count(),
            'testimonials' => Testimonial::query()->count(),
            'contact_messages' => ContactMessage::query()->count(),
            'unread_messages' => ContactMessage::query()->whereNull('read_at')->count(),
        ];
    }
}
