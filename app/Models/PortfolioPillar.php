<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Database\Factories\PortfolioPillarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioPillar extends Model
{
    /** @use HasFactory<PortfolioPillarFactory> */
    use HasFactory;

    use HasLocalizedContent;

    protected $fillable = ['title', 'description', 'icon', 'sort_order', 'active', 'translations'];

    protected function casts(): array
    {
        return ['active' => 'boolean', 'translations' => 'array'];
    }
}
