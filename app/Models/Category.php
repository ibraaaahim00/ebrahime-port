<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['name', 'slug', 'icon', 'active', 'sort_order', 'translations'];

    protected function casts(): array
    {
        return ['active' => 'boolean', 'translations' => 'array'];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
