<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPilihan extends Model
{
    use HasFactory;
    protected $table = "menu_pilihan";
    protected $fillable = [
        'id_user',
        'id_menu',
    ];
    public function Menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
