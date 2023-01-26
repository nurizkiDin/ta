<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataVariabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_variabel', function(Blueprint $table){
            $table->string('id_data')->primary();
            $table->string('username');
            $table->float('jarak_objek_cm');
            $table->float('terlihat_jelas_cm_kanan');
            $table->float('terlihat_jelas_cm_kiri');
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
