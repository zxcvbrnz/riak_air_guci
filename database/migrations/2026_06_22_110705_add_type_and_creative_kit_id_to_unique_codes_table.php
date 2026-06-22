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
            // 1. Menambahkan kolom type berupa enum (product atau kit) setelah kolom id
            $table->enum('type', ['product', 'kit'])->after('id');

            // 2. Menambahkan kolom creative_kit_id yang bersifat nullable
            $table->foreignId('creative_kit_id')->nullable()->constrained()->onDelete('set null')->after('type');

            // 3. Mengubah kolom product_id yang sudah ada menjadi nullable
            $table->foreignId('product_id')->nullable()->onDelete('set null')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unique_codes', function (Blueprint $table) {
            // 1. Mengembalikan product_id menjadi NOT NULL (sesuaikan jika awalnya memang tidak boleh null)
            $table->foreignId('product_id')->nullable(false)->change();

            // 2. Menghapus foreign key dan kolom creative_kit_id
            $table->dropForeign(['creative_kit_id']);
            $table->dropColumn('creative_kit_id');

            // 3. Menghapus kolom type
            $table->dropColumn('type');
        });
    }
};
