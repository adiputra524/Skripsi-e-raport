<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mata_pelajaran extends Model
{
    protected $table = 'mata_pelajarans';
    protected $fillable = ['id', 'rapor_header_id', 'nama_mata_pelajaran', 'nilai_uts', 'nilai_uas', 'catatan'];
    public $timestamps = false;

    protected $primaryKey = 'id';


    // public function Rapor_header()
    // {
    //     return $this->belongsTo('App\Raport_header');
    // }
}
