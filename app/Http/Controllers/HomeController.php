<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $data = Ads::with(['owner'])->take(10)->get();
         
        return view('home', compact('data'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $ads, $id)
    {   
        $data = Ads::find($id);
    
        return view('home', compact('data'));
    }
}
