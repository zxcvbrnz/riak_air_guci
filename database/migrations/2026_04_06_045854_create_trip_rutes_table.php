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
        Schema::create('trip_rutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultural_trip_id')->constrained()->onDelete('cascade');
            $table->string('title_id');
            $table->string('title_en');
            $table->text('description_id');
            $table->text('description_en');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_rutes');
    }
};
