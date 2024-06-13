<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "transaksi";
    protected $fillable = [
        'id_user',
        'nama_menu',
        'jumlah',
        'harga',
        'total',
        'dibayar',
        'diantar',
    ];
    public function Menu()
    {
        return $this->hasMany(Menu::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
