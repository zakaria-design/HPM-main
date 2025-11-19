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
        Schema::create('uang_kas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengeluaran', 100)->nullable();
            $table->enum('jenis_pengeluaran', ['konsumtif', 'operasional', 'peralatan']);
            $table->decimal('uang_keluar', 15, 2)->nullable()->default(0);
            $table->decimal('total_uang_keluar', 15, 2)->nullable()->default(0);
            $table->string('nama_donasi', 100)->nullable();
            $table->decimal('uang_masuk', 15, 2)->nullable()->default(0);
            $table->decimal('total_uang_masuk', 15, 2)->nullable()->default(0);
            $table->decimal('saldo', 15, 2)->nullable()->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_kas');
    }
};
