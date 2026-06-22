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
        Schema::create('kit_dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creative_kit_id')->constrained()->onDelete('cascade');
            $table->foreignId('kit_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('video_url');
            $table->string('motif_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kit_dashboards');
    }
};
