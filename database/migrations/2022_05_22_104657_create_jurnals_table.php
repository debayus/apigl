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
            $table->unsignedBigInteger('id_user');
            $table->string('no');
            $table->date('tanggal');
            $table->string('catatan');
            $table->unsignedBigInteger('id_proyek');
            $table->decimal('debit');
            $table->decimal('kredit');
            $table->boolean('tutupbuku');
            $table->boolean('batal');
            $table->string('batalketerangan');
            $table->unsignedBigInteger('id_tutupbuku');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_proyek')->references('id')->on('proyeks');
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
