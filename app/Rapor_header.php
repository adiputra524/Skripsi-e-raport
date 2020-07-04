<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapor_header extends Model
{
    protected $table = "rapor_headers";
    protected $fillable = ['id', 'rapor_id', 'tahun_ajaran','semester','grade'];
    public $timestamps = false;

    protected $primaryKey = 'id';

    // public function Raport()
    // {
    //     return $this->belongsTo('App\Raport');
    // }

    // public function Mata_Pelajaran()
    // {
    //     return $this->hasOne('App\Mata_pelajaran','rapor_header_id');
    // }
}
