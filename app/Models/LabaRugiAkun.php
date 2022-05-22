<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugiAkun extends Model
{
    use HasFactory;
    protected $table = 'laba_rugi_akuns';
    protected $fillable = [
        'id',
        'id_user',
        'id_akun',
        'tipe'
    ];
}
