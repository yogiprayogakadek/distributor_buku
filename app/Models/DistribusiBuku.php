<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiBuku extends Model
{
    use HasFactory;

    protected $table = 'distribusi_buku';
    protected $guarded = ['id'];

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }

    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class, 'id', 'distributor_id');
    // }
}
