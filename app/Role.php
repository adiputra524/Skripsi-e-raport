<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $table='roles';
   protected $fillable=['id','role_name','created_at','update_at'];


}
