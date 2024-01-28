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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->integer('total_pembayaran');
            $table->enum('jenis_pembayaran', ['Tunai', 'Transfer'])->nullable();
            $table->string('bukti_pembayaran', 100)->nullable();
            $table->enum('status_pembayaran', ['Belum dibayar', 'Menunggu Konfirmasi', 'Diterima'])->default('Belum dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
