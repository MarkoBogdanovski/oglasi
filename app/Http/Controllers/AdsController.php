<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ads;
use Storage;

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
    public function index($list = null)
    {
        if(isset($list) && !empty($list) && $list == "all") {
            $onHold = Ads::with(['category', 'owner'])
            ->where([
                ['approved', false],
                ['updated_at', null],
            ])
            ->get()->toArray();

            return view('ads', compact('onHold', 'list'));
        } else {
            $onHold = Ads::with(['category', 'owner'])
            ->where([
                ['approved', false],
                ['updated_at', null],
            ])
            ->take(4)->get()->toArray();
            $approved = Ads::with(['category', 'owner'])->where('approved', true)->get()->toArray();

            return view('ads', compact('onHold', 'approved', 'list'));
        }
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
        if(Auth::user()->role_id == 1) { 
            return redirect('home')->with('status', 'No permission');
        }

        $path = $this->uploadImage($request);
        if(!$path) {
            return  redirect('ad')->with('status', 'Error while uploading image');
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
                'image' => $path
            ]);

            return redirect('ad')->with('status', "Ad has been successfully crated on the <a class='alert-link' target='_blank' href='{$id}/{$request->get('name')}'>link</a>.");
        } catch (\Exception $e){
            return redirect('ad')->with('status', $e->getMessage());
        }
    }

    /**
     * Update the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function update($id, $status)
    {
        if(Auth::user()->role_id != 1) { 
            return redirect('home');
        }

        if($status == 'approve') {
            $status = true;
        } else if($status == 'ignore') {
            $status = false;
        } else {
            return redirect('ads')->with('status', ['Error', 'Invalid argument!']);
        }

        $ad = Ads::find($id);
        $ad->approved = $status;
        $ad->updated_at = now();
        $ad->save();

        return redirect('ads')->with('status', ['Success','Ad has been handled.']);
    }

 /**
     * Update the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        if(Auth::user()->role_id != 1) { 
            return redirect('home');
        }

        $ids = $request->get('ids');
        $status = $request->get('status');

        if($status == true) {
            $status = true;
            $ads = Ads::whereIn('id', $ids)->update(['approved' => $status, 'updated_at' => now()]);
        } else if($status == false) {
            $status = false;
            $ads = Ads::whereIn('id', $ids)->update(['approved' => $status, 'updated_at' => now()]);
        } else {
            return response()->json(['Invalid argument!']);
        }

        return response()->json(['Ad has been handled.']);
    }

    private function uploadImage(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
        try {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(storage_path('app/public/cars'), $imageName);
            $path = Storage::url('cars/'.$imageName); 

            return $path;
        } catch (\Exception $e) {
            return false;
        }
    }
}
