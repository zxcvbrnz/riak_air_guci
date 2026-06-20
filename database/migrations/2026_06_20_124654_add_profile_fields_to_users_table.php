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
        Schema::table('users', function (Blueprint $table) {
            $table->string('asal_provinsi')->nullable()->after('email');
            $table->string('asal_kota')->nullable()->after('asal_provinsi');
            $table->string('tempat_lahir')->nullable()->after('asal_kota');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('no_wa', 20)->nullable()->after('tanggal_lahir');
            // Menggunakan enum untuk gender agar datanya lebih valid dan konsisten
            $table->enum('gender', ['L', 'P'])->nullable()->after('no_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'asal_provinsi',
                'asal_kota',
                'tempat_lahir',
                'tanggal_lahir',
                'no_wa',
                'gender'
            ]);
        });
    }
};