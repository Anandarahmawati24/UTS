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
        Schema::create('m_ukm', function (Blueprint $table) {
            $table->id('id_ukm');
            $table->string('nama_ukm');
            $table->unsignedBigInteger('id_kategori');
            $table->string('email');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->date('tanggal_berdiri');
            $table->string('status')->default('aktif');
            $table->timestamps();
        
            // Relasi ke tabel kategori_ukm
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_ukm')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_ukm');
    }
};
