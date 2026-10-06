<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['name', 'position', 'company', 'image_path', 'testimonial', 'rating', 'active', 'sort_order', 'translations'];

    protected function casts(): array
    {
        return ['rating' => 'integer', 'active' => 'boolean', 'translations' => 'array'];
    }
}
