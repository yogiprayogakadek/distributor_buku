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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['Laki - Laki', 'Perempuan']);
            $table->char('telp', 16);
            $table->string('username', 100);
            $table->string('password');
            $table->string('email', 100);
            $table->enum('role', ['Admin', 'Direktur', 'Distributor']);
            $table->string('foto', 100)->default('assets/uploads/users/default.png');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
