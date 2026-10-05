<?php

namespace App\Models;

use Database\Factories\TechnologyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    /** @use HasFactory<TechnologyFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'category', 'active', 'sort_order'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }
}
