<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapor_header extends Model
{
    protected $table ="rapor_headers";
    protected $fillable=['id','rapor_id','tahun_ajaran'];
    public $timestamps = false;
}
