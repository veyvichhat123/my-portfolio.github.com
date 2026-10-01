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
        // create_projects_table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_km')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_km')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('technologies')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
