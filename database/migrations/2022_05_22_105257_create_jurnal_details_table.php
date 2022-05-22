<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalDetailsTable extends Migration
{
    protected $primaryKey = ['id_jurnal', 'id_akun'];
    public $incrementing = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jurnal');
            $table->unsignedBigInteger('id_akun');
            $table->decimal('debit');
            $table->decimal('kredit');
            $table->string('catatan')->nullable();
            $table->string('komponen')->nullable();
            $table->unsignedBigInteger('id_struktur_akun')->nullable();
            $table->unsignedBigInteger('id_struktur_akun_detail')->nullable();
            $table->string('normalpos')->nullable();
            $table->integer('level')->nullable();
            $table->string('no')->nullable();
            $table->string('nama')->nullable();
            $table->timestamps();
            $table->foreign('id_jurnal')->references('id')->on('jurnals');
            $table->foreign('id_akun')->references('id')->on('akuns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnal_details');
    }
}
