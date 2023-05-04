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
            $table->foreignId('user_id')->nullable()->comment('validator')->references('id')->on('users')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->enum('jenis_pembayaran', ['Tunai', 'Transfer']);
            $table->string('bukti_pembayaran', 100)->nullable();
            $table->enum('status_pembayaran', ['Menunggu Konfirmasi', 'Diterima', 'Ditolak'])->default('Menunggu Konfirmasi');
            $table->text('keterangan')->comment('apabila pembyaran gagal')->nullable();
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
