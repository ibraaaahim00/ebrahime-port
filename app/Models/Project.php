<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = [
        'category_id', 'title', 'slug', 'short_description', 'full_description',
        'image_path', 'thumbnail_path', 'github_url', 'live_demo_url', 'badge',
        'client_company', 'project_status', 'start_date', 'completion_date',
        'case_study', 'featured', 'published', 'active', 'sort_order', 'translations',
    ];

    protected function casts(): array
    {
        return [
            'case_study' => 'array',
            'start_date' => 'date',
            'completion_date' => 'date',
            'featured' => 'boolean',
            'published' => 'boolean',
            'active' => 'boolean',
            'translations' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class)->withTimestamps()->orderBy('sort_order');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('published', true)->where('active', true);
    }

    public function imageUrl(): ?string
    {
        $path = $this->thumbnail_path ?: $this->image_path;

        return $path ? Storage::url($path) : null;
    }
}
