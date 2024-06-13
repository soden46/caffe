<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "komen";
    protected $fillable = [
        'komentar',
        'id_user',
        'status',
        'deleted_at'
    ];
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
