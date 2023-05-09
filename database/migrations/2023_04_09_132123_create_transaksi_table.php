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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 100);
            $table->date('tanggal_pesanan');
            $table->foreignId('distributor_id')->references('id')->on('distributor')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->comment('validator')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status_pesanan', ['Belum Bayar', 'Menunggu Konfirmasi', 'Dikemas', 'Dikirim', 'Diterima', 'Dibatalkan'])->default('Belum Bayar');
            $table->text('keterangan')->comment('apabila transaksi gagal dalam pembayaran')->nullable();
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
