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
        Schema::create('sph_gagal', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nama_customer');
            $table->decimal('nominal', 15, 2)->nullable();
            $table->string('user_id', 20); // HARUS sama tipe dengan users.user_id
            $table->text('update')->nullable();
            $table->timestamps();

            // foreign key ke kolom user_id di tabel users
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sph_gagal');
    }
};
