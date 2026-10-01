<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('school_en');
            $table->string('school_km')->nullable();
            $table->string('degree_en');
            $table->string('degree_km')->nullable();
            $table->string('field_en')->nullable();
            $table->string('field_km')->nullable();
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
        Schema::dropIfExists('education');
    }
};
