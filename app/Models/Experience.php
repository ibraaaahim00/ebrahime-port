<?php

namespace App\Models;

use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory;

    protected $fillable = ['company', 'position', 'description', 'start_date', 'end_date', 'current', 'location', 'technologies', 'highlights', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'current' => 'boolean', 'technologies' => 'array', 'highlights' => 'array', 'active' => 'boolean'];
    }
}
