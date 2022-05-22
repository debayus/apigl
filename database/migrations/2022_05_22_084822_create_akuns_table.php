<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('komponen');
            $table->unsignedBigInteger('id_struktur_akun');
            $table->unsignedBigInteger('id_struktur_akun_detail');
            $table->string('normalpos');
            $table->integer('level');
            $table->string('no');
            $table->string('nama');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_struktur_akun')->references('id')->on('struktur_akuns');
            $table->foreign('id_struktur_akun_detail')->references('id')->on('struktur_akun_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akuns');
    }
}
