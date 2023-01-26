<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hasil extends Model
{
    public $timestamps = false;
    protected $table = "tbl_hasil";

    protected $fillable = [
        'username',
        'presbiopi',
        'kekuatan_lensa_kiri',
        'kekuatan_lensa_kanan'
    ];
}
