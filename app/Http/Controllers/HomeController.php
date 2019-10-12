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
        $ads = [];
        $ads = Ads::with(['category', 'owner'])->where('approved', true)->paginate(10);
         
        return view('home', compact('ads'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $ads, $id)
    {   
        $ad = [];
        $ad = Ads::with(['category', 'owner'])->where([
            ['id', $id],
            ['approved', true]
        ])->first()->toArray();

        return view('ad')->with([
            'ad' => $ad,
        ]);
    }
}
