<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    public $timestamps = false;
    protected $table = "tbl_uji";

    protected $fillable = [
        'dokname',
        'nama',
        'password'
    ];
}
