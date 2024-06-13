<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "menu";

    protected $fillable = [
        'judul',
        'deskripsi',
        'harga',
        'harga_lama',
        'foto',
        'id_kategori',
    ];
    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
