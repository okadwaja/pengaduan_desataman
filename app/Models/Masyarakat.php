<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'nik', 'no_telp', 'alamat', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

