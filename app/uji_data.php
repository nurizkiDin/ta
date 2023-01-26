<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class uji_data extends Model
{
    public $timestamps = false;
    protected $table = "tbl_uji";

    protected $fillable = [
        'dokname',
        'usia',
        'jenis_rabun',
        'astigmatism',
        'tingkat_prod_airMata',
        'jenis_lens'
    ];
}
