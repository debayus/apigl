<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;
    protected $table = 'kontaks';
    protected $fillable = [
        'id',
        'id_user',
        'nama',
        'telp',
        'whatsapp',
        'email',
        'perusahaan',
        'alamat',
        'catatan'
    ];
}
