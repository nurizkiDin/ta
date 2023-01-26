<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user extends Model {
    public $timestamps = false;
    protected $table = "tbl_user";

    protected $fillable = [
        "username", 
        'nama',
        'jenis_kelamin',
        'usia',
        "password"
    ];
}