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
        Schema::table('unique_codes', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom yang sudah ada (misal setelah creative_kit_id)
            $table->string('kit_variant')->nullable()->after('creative_kit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unique_codes', function (Blueprint $table) {
            // Menghapus kolom jika melakukan rollback
            $table->dropColumn('kit_variant');
        });
    }
};
