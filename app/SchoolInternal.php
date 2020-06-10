<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolInternal extends Model
{
	protected $table='school_internals';
	protected $fillable=['id','name','email','phone','password','profile_picture','role_id','created_at','update_at'];
}


public function role()
{
	return $this->hasOne('App\Role','role_id');
}