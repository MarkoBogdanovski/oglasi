<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ads;

class AdsController extends Controller

{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $data = Ads::take(10)->get();
         
        return view('home', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id == 1) { 
            return redirect('home');
        }

        return view('create_ad');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role_id < 2) { 
            dd(Auth::user()->role_id);
           //return redirect('home');
        }

        try {        
            $id = Ads::insertGetId([
                'owner_id' => Auth::user()->id, 
                'approved' => FALSE,
                'name' => $request->get('name'),
                'category' => $request->get('category'),
                'price' => $request->get('price'),
                'year' => $request->get('year'),
                'range' => $request->get('range'),
                'image' => $request->get('range')
            ]);

            return redirect('ad')->with('success', "Ad has been successfully crated on the <a class='alert-link' target='_blank' href='{$id}/{$request->get('name')}'>link</a>.");
        } catch (\Exception $e){
            return redirect('ad')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $ads)
    {
        //
    }
}
