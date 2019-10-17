<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ads;
use Storage;
use Validator;

class AdsController extends Controller
{ 
   /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'category' => 'required|integer|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')),
            'range' => 'required|integer',
            'price' => 'required|integer',
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         *  Set Audi Category ID
        */
        parent::setAudiId();

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($list = null)
    {
        if(Auth::user()->role_id != 1) { 
            return redirect('home');
        }

        if(!empty($list) && $list == "all") {
            $onHold = Ads::with(['category', 'owner'])->where([
                ['approved', false],
                ['updated_at', null],
            ])->latest('created_at')->get();

            return view('ads', compact('onHold', 'list'));
        } else {
            $onHold = Ads::with(['category', 'owner'])->where([
                ['approved', false],
                ['updated_at', null],
            ])->latest('created_at')->take(4)->get();

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

        $validator = $this->validator($request->all());        
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages()->first());
        }

        if($request->get('category') == $this->audiId) {
            return redirect()->back()->with('error', 'Category with limited access!');
        }

        $path = $this->uploadImage($request);
        if(!$path) {
            return redirect()->back()->with('error',  'Error while uploading image');
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
                'image' => $path,
                'created_at' => now()
            ]);

           return redirect()->back()->with('success', "Ad has been sent on the review. It will be available on this <a class='alert-link' target='_blank' href='{$id}/{$request->get('name')}'>address</a>.");
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ids = null, $status = null)
    {
        $ids = !empty($request->get('ids')) ? $request->get('ids') : [$ids];
        $status = !empty($request->get('status')) ? $request->get('status') : (boolean) $status;

        if(Auth::user()->role_id != 1) { 
            return redirect('home');
        }

        try {
            $ads  = Ads::whereIn('id', $ids)->update(['approved' => $status, 'updated_at' => now()]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Unexpected error.");
        }

        if($request->ajax()){
            return response()->json(['success' => 'Ad has been processed.']);
        }

        return redirect()->back()->with('success', 'Ad has been processed.');
    }

    /**
     *  Handle image upload
     *  @param \Illuminate\Http\Request $request
     *  @return string $path
     */
    private function uploadImage(Request $request) {
        $validator = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000000000',
        ]); 

        try {
            $imageName = $this->uniqString().'.'.$request->image->extension();  
            $request->image->move(storage_path('app/public/cars'), $imageName);
            $path = Storage::url('cars/'.$imageName); 

            return $path;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Generate random string
     *  @return string $filename
     */
    private function uniqString() { 
        $string = uniqid('img_'); 
        $filename = 
            substr($string,0,8) . '-' . 
            substr($string,8,4) . '-' . 
            substr($string,12,4). '-' . 
            substr($string,16,4). '-' . 
            substr($string,20); 
        return $filename;
    }
}
