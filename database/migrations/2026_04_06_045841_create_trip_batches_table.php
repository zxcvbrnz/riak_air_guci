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
        Schema::create('trip_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultural_trip_id')->constrained()->onDelete('cascade');
            $table->date('departure_date');
            $table->integer('available_seats')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_batches');
    }
};
