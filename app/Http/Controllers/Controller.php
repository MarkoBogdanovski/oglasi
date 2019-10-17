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

   	protected function setAudiId() 
    {
   	    $categoryId = Category::where('name', 'audi')->first()->id;
        
	    if($categoryId !== NULL && $this->audiId != $categoryId){
	       $this->audiId = $categoryId;
	    }
	}
}
