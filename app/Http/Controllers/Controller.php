<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        /**
     	* Audi Category ID
     	*/
   	protected $audiId;

   	protected function setAudiId() {
   		$category = Category::where('name', 'audi')->first();


	        if($category !== NULL && $this->audiId != $category->id){
	            $this->audiId = $category->id;
	        }
	}
}
