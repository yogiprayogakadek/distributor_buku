<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    private function roles()
    {
        return [
            'Admin', 'Direktur', 'Distributor'
        ];
    }


    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id', 'user_id');
    }

    public function transaksi() // validator transaksi
    {
        return $this->hasMany(Transaksi::class, 'id', 'user_id');
    }

    public function pembayaran() // validator transaksi
    {
        return $this->hasMany(Pembayaran::class, 'id', 'user_id');
    }

    public function hasRole($role){
        if ($this->role == $role) {
            return true;
        }

        return false;
    }
}
