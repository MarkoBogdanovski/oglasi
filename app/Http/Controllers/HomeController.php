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
        $ads = Ads::with(['category', 'owner'])->where('approved', true)->latest('created_at')->paginate(9);
         
        return view('home', compact('ads'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $ads = [];
        $ads = Ads::with(['category', 'owner'])->where([
            ['name', 'LIKE', '%'.$request->get('q').'%'],
            ['category', $request->get('category')],
            ['approved', true]
        ])->latest()->paginate(9);

        return response()->json($ads);
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
