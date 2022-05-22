<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoAwalDetail extends Model
{
    use HasFactory;
    protected $table = 'saldo_awal_details';
    protected $fillable = [
        'id_akun',
        'id_saldo_awal',
        'nilai',
        'komponen',
        'id_struktur_akun',
        'id_struktur_akun_detail',
        'normalpos',
        'level',
        'no',
        'nama',
        'id_struktur_akun_nama',
        'id_struktur_akun_detail_nama',
    ];
}
