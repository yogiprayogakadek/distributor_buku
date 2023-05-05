<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id', 'transaksi_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pembayaran_id', 'id');
    }
}
