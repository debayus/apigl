<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrukturAkunDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('struktur_akun_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_struktur_akun');
            $table->string('nama');
            $table->boolean('cash');
            $table->boolean('bank');
            $table->timestamps();
            $table->foreign('id_struktur_akun')->references('id')->on('struktur_akuns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('struktur_akun_details');
    }
}
