<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    public $timestamps = false;
    protected $table = "data_variabel";

    protected $fillable = [
        'id_data', 
        'username', 
        'jarak_objek_cm', 
        'terlihat_jelas_cm_kanan', 
        'terlihat_jelas_cm_kiri'
    ];
}
