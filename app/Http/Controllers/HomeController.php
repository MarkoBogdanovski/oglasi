<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    //
	public function index() {
		$data = User::with(['role', 'ads'])->take(2)->get();
		return $data;
	}	
}
