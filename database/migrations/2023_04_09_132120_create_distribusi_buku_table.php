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
        Schema::create('distribusi_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->references('id')->on('distributor')->onDelete('cascade');
            $table->json('data_buku');
            $table->date('tanggal_distribusi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_buku');
    }
};
