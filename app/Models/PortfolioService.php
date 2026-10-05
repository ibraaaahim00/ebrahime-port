<?php

namespace App\Models;

use Database\Factories\PortfolioServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioService extends Model
{
    /** @use HasFactory<PortfolioServiceFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'sort_order', 'active'];

    protected function casts(): array
    {
        return ['active' => 'boolean'];
    }
}
