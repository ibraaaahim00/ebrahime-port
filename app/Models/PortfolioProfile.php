<?php

namespace App\Models;

use Database\Factories\PortfolioProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    /** @use HasFactory<PortfolioProfileFactory> */
    use HasFactory;

    protected $fillable = ['name', 'professional_title', 'status', 'short_bio', 'full_bio', 'profile_image_path', 'cv_path', 'email', 'phone', 'location', 'github_url', 'linkedin_url', 'facebook_url', 'instagram_url', 'whatsapp_url', 'available', 'years_of_experience', 'hero_cta_text', 'hero_cta_url'];

    protected function casts(): array
    {
        return ['available' => 'boolean'];
    }
}
