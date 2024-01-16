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
        Schema::create('tutorial_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->foreignId('tutorial_id')->constrained('tutorials');
            $table->timestamps();

            $table->index('keyword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_keywords');
    }
};
