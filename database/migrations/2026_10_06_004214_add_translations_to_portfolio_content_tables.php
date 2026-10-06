<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['projects', 'categories', 'technologies', 'skills', 'experiences', 'education', 'portfolio_services', 'testimonials', 'portfolio_profiles', 'site_settings', 'sections', 'portfolio_pillars'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->json('translations')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['projects', 'categories', 'technologies', 'skills', 'experiences', 'education', 'portfolio_services', 'testimonials', 'portfolio_profiles', 'site_settings', 'sections', 'portfolio_pillars'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->dropColumn('translations');
            });
        }
    }
};
