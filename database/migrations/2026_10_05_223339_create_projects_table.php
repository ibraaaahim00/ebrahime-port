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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description');
            $table->longText('full_description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('github_url')->nullable();
            $table->string('live_demo_url')->nullable();
            $table->string('badge')->nullable();
            $table->string('client_company')->nullable();
            $table->string('project_status')->default('completed');
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('case_study')->nullable();
            $table->timestamps();

            $table->index(['published', 'active', 'featured', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
