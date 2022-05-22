<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoAwalDetailsTable extends Migration
{
    protected $primaryKey = ['id_akun', 'id_saldo_awal'];
    public $incrementing = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_awal_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_akun');
            $table->unsignedBigInteger('id_saldo_awal');
            $table->decimal('nilai');
            $table->string('komponen')->nullable();
            $table->unsignedBigInteger('id_struktur_akun')->nullable();
            $table->unsignedBigInteger('id_struktur_akun_detail')->nullable();
            $table->string('normalpos')->nullable();
            $table->integer('level')->nullable();
            $table->string('no')->nullable();
            $table->string('nama')->nullable();
            $table->string('id_struktur_akun_nama')->nullable();
            $table->string('id_struktur_akun_detail_nama')->nullable();
            $table->timestamps();
            $table->foreign('id_akun')->references('id')->on('akuns');
            $table->foreign('id_saldo_awal')->references('id')->on('saldo_awals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saldo_awal_details');
    }
}
