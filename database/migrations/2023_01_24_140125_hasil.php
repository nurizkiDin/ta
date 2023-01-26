<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Hasil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_hasil', function(Blueprint $table){
            $table->string('username')->unique();
            $table->string('presbiopi');
            $table->float('kekuatan_lensa_kiri');
            $table->float('kekuatan_lensa_kanan');
            $table->foreign('username')->references('username')->on('tbl_user');
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
