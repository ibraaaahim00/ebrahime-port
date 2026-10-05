<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    protected $fillable = ['name', 'position', 'company', 'image_path', 'testimonial', 'rating', 'active', 'sort_order'];

    protected function casts(): array
    {
        return ['rating' => 'integer', 'active' => 'boolean'];
    }
}
