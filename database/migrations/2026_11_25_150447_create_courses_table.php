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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('type', 32);
            $table->string('status', 32)->default('draft');
            $table->unsignedInteger('price_cents')->default(0);
            $table->string('currency', 3)->default('USD');
            $table->unsignedSmallInteger('duration_hours')->nullable();
            $table->string('level', 50)->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'type']);
            $table->index('instructor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
