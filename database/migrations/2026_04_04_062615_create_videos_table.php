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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('category_id');
            $table->string('category_en');
            $table->string('duration'); // Format '05:20'
            $table->string('thumb');    // Path untuk cover image/thumbnail
            $table->string('video_url')->nullable(); // Untuk link YouTube/Vimeo atau path file
            $table->boolean('is_featured')->default(false); // Opsional: untuk highlight di UI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
