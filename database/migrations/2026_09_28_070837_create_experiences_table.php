<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_en');
            $table->string('company_km')->nullable();
            $table->string('position_en');
            $table->string('position_km')->nullable();
            $table->string('location_en')->nullable();
            $table->string('location_km')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_km')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_km')->nullable();
            $table->string('logo')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
