<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('professional_title');
            $table->string('status')->nullable();
            $table->text('short_bio')->nullable();
            $table->longText('full_bio')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->boolean('available')->default(true);
            $table->unsignedTinyInteger('years_of_experience')->nullable();
            $table->string('hero_cta_text')->nullable();
            $table->string('hero_cta_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_profiles');
    }
};
