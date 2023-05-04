<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $table = 'distributor';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id', 'distributor_id');
    }
}
