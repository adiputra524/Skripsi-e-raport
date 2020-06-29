<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    protected $table='raports';
    protected $fillable=['id','student_id','created_at','update_at'];

    protected $primaryKey = 'id';
}
