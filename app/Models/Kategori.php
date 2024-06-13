<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "kategori";
    protected $fillable = [
        'judul',
        //'slug',
        'aktif'
    ];
    /* public function getRouteKeyName()
    {
        return 'slug';
    }*/

    // relation with menu
    public function Menu()
    {
        return $this->hasMany(Menu::class);
    }
}
