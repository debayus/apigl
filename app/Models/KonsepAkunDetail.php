<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsepAkunDetail extends Model
{
    use HasFactory;
    protected $table = 'konsep_akun_details';
    protected $fillable = [
        'level',
        'id_konsep_akun',
        'jumlahdigit'
    ];
}
