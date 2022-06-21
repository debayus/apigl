<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_perusahaan');
            $table->unsignedBigInteger('id_user_create');
            $table->unsignedBigInteger('id_user_update')->nullable();
            $table->unsignedBigInteger('id_user_tutupbuku')->nullable();
            $table->unsignedBigInteger('id_user_batal')->nullable();
            $table->string('no');
            $table->date('tanggal');
            $table->string('catatan')->nullable();
            $table->unsignedBigInteger('id_proyek');
            $table->decimal('debit');
            $table->decimal('kredit');
            $table->boolean('tutupbuku');
            $table->boolean('batal');
            $table->string('batalketerangan')->nullable();
            $table->unsignedBigInteger('id_tutupbuku')->nullable();
            $table->timestamps();
            $table->foreign('id_perusahaan')->references('id')->on('perusahaans');
            $table->foreign('id_proyek')->references('id')->on('proyeks');
            $table->foreign('id_user_create')->references('id')->on('users');
            $table->foreign('id_user_update')->references('id')->on('users');
            $table->foreign('id_user_tutupbuku')->references('id')->on('users');
            $table->foreign('id_user_batal')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnals');
    }
}
