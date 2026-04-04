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
        Schema::create('creative_kits', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('level_id'); // Pemula, Ahli
            $table->string('level_en'); // Beginner, Advanced
            $table->text('description_id');
            $table->text('description_en');
            $table->decimal('price', 15, 2);
            $table->string('image');
            $table->string('link_shopee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creative_kits');
    }
};
