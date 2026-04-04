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
        Schema::create('motifs', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // Path gambar (misal: motif-air-guci.jpg)
            $table->string('badge')->nullable(); // Misal: Signature Motif, Classic Banjar

            // Nama Motif (ID & EN)
            $table->string('name_id');
            $table->string('name_en');

            // Deskripsi Filosofi (ID & EN)
            $table->text('description_id');
            $table->text('description_en');

            // Untuk mengatur urutan tampilan dan layouting (seperti md:mt-32)
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motifs');
    }
};
