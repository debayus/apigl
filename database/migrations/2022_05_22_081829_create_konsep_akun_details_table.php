<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsepAkunDetailsTable extends Migration
{
    protected $primaryKey = ['level', 'id_konsep_akun'];
    public $incrementing = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsep_akun_details', function (Blueprint $table) {
            $table->integer('level');
            $table->unsignedBigInteger('id_konsep_akun');
            $table->integer('jumlahdigit');
            $table->timestamps();
            $table->foreign('id_konsep_akun')->references('id')->on('konsep_akuns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsep_akun_details');
    }
}
