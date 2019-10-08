<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
	public $timestamps = false;

	protected $fillable = [
	        'name', 'display_name', 'id'
	];

	public function users()
	{
	    return $this->hasMany('App\Models\User', 'role_id', 'id');
	}
}
