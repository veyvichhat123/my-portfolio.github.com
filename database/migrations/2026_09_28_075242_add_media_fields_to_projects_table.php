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
        Schema::table('projects', function (Blueprint $table) {
            //
            Schema::table('projects', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->after('description_km');
                $table->json('gallery')->nullable();
                $table->string('video_url')->nullable();
                $table->string('video_file')->nullable();
                $table->longText('content_en')->nullable();
                $table->longText('content_km')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn([
                    'thumbnail', 'gallery', 'video_url', 'video_file',
                    'content_en', 'content_km',
                ]);
            });
        });
    }
};
