<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;
use App\Models\Category;

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
        $category = !empty($request->get('category')) ? $request->get('category') : null;

        if(!empty($request->get('category'))) {
            $ads = Ads::with(['category', 'owner'])->where([
                ['name', 'LIKE', '%'.$request->get('q').'%'],
                ['category', $request->get('category')],
                ['approved', true]
            ])->latest('created_at')->paginate(9);

        } else {
            $ads = Ads::with(['category', 'owner'])->where([
                ['name', 'LIKE', '%'.$request->get('q').'%'],
                ['approved', true]
            ])->latest('created_at')->paginate(9);
        }

        if ($request->ajax()) {
            return view('partials._partial_results')->with([
                'ads' => $ads->appends($request->except('_token')),
                'request' => $request,
            ]);
        }

        return view('home')->with([
            'ads' => $ads,
        ]);
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
        ])->first();

        return view('ad')->with([
            'ad' => $ad,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listCategories(Request $request)
    {
        $data = [];
        $data = Category::all();

        return response()->json($data);
    }
}
