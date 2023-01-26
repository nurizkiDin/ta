<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblUji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_uji', function(Blueprint $table){
            $table->increments('id_uji');
            $table->string('dokname');
            $table->string('usia');
            $table->string('jenis_rabun');
            $table->string('astigmatism');
            $table->string('tingkat_prod_airMata');
            $table->string('jenis_lens');
            $table->foreign('dokname')->references('dokname')->on('tbl_dokter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
