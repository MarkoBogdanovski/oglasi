<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
	public $timestamps = false;

	protected $fillable = [
	        'owner_id', 'approved', 'category', 'name', 'price', 'year', 'range', 'image', 'id'
	];

	public function owner()
	{
	    return $this->belongsTo(User::class, 'owner_id');	
	}
}
