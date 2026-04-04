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
        Schema::create('movement_schools', function (Blueprint $table) {
            $table->id();
            $table->string('label_id'); // Rangkai Ilmu
            $table->string('label_en'); // Education Series
            $table->string('title_id');
            $table->string('title_en');
            $table->text('description_id');
            $table->text('description_en');
            $table->string('media_path'); // Path foto/thumbnail video
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('video_url')->nullable(); // Link video jika tipe video
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_schools');
    }
};
