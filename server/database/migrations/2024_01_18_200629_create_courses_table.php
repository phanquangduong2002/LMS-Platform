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
            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->double('price')->default(0);
            $table->string('image')->nullable();
            $table->foreignId('course_category_id')->constrained('course_categories');
            $table->boolean('published')->default(false);
            $table->boolean('paid')->default(false);
            $table->foreignId('instructor')->constrained('users');
            $table->double('totalHours')->default(0);
            $table->integer('enrolls')->default(0);
            $table->double('totalRatings')->default(0);
            $table->timestamps();
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
