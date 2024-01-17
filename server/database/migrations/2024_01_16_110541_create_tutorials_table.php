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
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('tutorial_category_id')->constrained('tutorial_categories');
            $table->longText('content');
            $table->timestamps();

            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table("tutorials", function (Blueprint $table) {
        //     $table->dropForeign('tutorials_tutorial_category_id_foreign');
        //     $table->dropColumn(['tutorial_category_id']);
        // });

        Schema::dropIfExists('tutorials');
    }
};
