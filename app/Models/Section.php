<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /** @use HasFactory<SectionFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['key', 'tag', 'title', 'description', 'content', 'active', 'sort_order', 'translations'];

    protected function casts(): array
    {
        return ['content' => 'array', 'active' => 'boolean', 'translations' => 'array'];
    }
}
