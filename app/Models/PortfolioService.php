<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\PortfolioServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioService extends Model
{
    /** @use HasFactory<PortfolioServiceFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['title', 'description', 'icon', 'sort_order', 'active', 'translations'];

    protected function casts(): array
    {
        return ['active' => 'boolean', 'translations' => 'array'];
    }
}
