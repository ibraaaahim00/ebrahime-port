<?php

namespace App\Models;

use Database\Factories\PortfolioPillarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioPillar extends Model
{
    /** @use HasFactory<PortfolioPillarFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}
