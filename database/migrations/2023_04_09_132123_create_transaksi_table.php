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
            $table->string('kode_transaksi', 100);
            $table->date('tanggal_transaksi');
            $table->foreignId('distributor_id')->references('id')->on('distributor')->onDelete('cascade');
            $table->foreignId('distribusi_buku_id')->references('id')->on('distribusi_buku')->onDelete('cascade');
            $table->foreignId('buku_id')->references('id')->on('buku')->onDelete('cascade');
            $table->integer('total_pengembalian');
            $table->integer('total_pembayaran');
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
