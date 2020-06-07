<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    protected $table='raports';
    protected $fillable=['id','student_id','nilai_uts','nilai_uas','created_at','update_at'];
}
