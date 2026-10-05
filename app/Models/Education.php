<?php

namespace App\Models;

use Database\Factories\EducationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /** @use HasFactory<EducationFactory> */
    use HasFactory;

    protected $table = 'education';

    protected $fillable = ['institution', 'degree', 'field', 'description', 'start_date', 'end_date', 'location', 'active', 'sort_order'];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'active' => 'boolean'];
    }
}
