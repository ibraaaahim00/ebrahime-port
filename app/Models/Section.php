<?php

namespace App\Models;

use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /** @use HasFactory<SectionFactory> */
    use HasFactory;

    protected $fillable = ['key', 'tag', 'title', 'description', 'content', 'active', 'sort_order'];

    protected function casts(): array
    {
        return ['content' => 'array', 'active' => 'boolean'];
    }
}
