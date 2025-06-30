<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaDesa extends Model
{
    use HasFactory;

    protected $table = 'kepala_desa';
    
    protected $fillable = [
        'user_id', 'nip', 'no_telp', 'foto', 'masa_jabatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

