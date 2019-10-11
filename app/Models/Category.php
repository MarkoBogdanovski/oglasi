<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;

	protected $fillable = [
	        'name', 'display_name', 'id'
	];

	/**
	   * Get the ads owned by user
	 */
	public function ads()
	{
	        return $this->hasMany('App\Models\Ads', 'category');
	}
}
