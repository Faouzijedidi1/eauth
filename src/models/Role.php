<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	protected $table = 'roles';

	public function users()
	{
	  return $this->belongsToMany('App\User');
	}
}
