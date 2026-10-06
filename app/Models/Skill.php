<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['name', 'category', 'category_label', 'level', 'icon', 'tag', 'sort_order', 'active', 'translations'];

    protected function casts(): array
    {
        return ['active' => 'boolean', 'translations' => 'array'];
    }
}
