<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblStudent extends Model
{
    protected $table='tbl_students';
    protected $fillable=['id','nama','nisn','nis','email','password','phone','profile_picture','class_id','created_at','updated_at'];
}
