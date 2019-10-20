<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ads;
use App\Handlers\ExternalHandler;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id > 1) { 
            return redirect('home');
        }
        
        return view('category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->get('name'))){
            return redirect('category')->with('error', 'Enter valid name!');
        }

        $slug = $this->createSlug($request->get('name'));
        try {        
            $id = Category::insertGetId([
                'name' => $slug, 'display_name' => trim($request->get('name'))
            ]);

            return redirect('category')->with('success', "Category has been successfully crated on the <a class='alert-link' target='_blank' href='/search?category={$id}'>link</a>.");
        } catch (\Exception $e){
            return redirect('category')->with('error', 'Insert failed!');
        }
    }

     /**
     * Grab external data and populate DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadExternal(Request $request)
    {
        if(Auth::user()->role_id > 1) { 
            return redirect('home');
        }

        $status = [];
        $externalHandler = new ExternalHandler();
        $ads = $externalHandler->getData();
        $categoryId =  Category::where('name', 'audi')->first()->id;

        foreach($ads as $ad) {
            try {
                $id = $ad['id'];
                Ads::updateOrInsert(
                        ['external_id' => $id, 'owner_id' => 0],
                        ['name' => $ad['name'], 'image' => $ad['image'], 'price' => $ad['price'], 'range' => $ad['range'], 'year' => $ad['year'], 'category' => $categoryId, 'approved' => true]
                );

                $status['s'][$id] = $ad['name'];
            } catch (\Exception $e) {
                $status['f'][$id] = $e->getMessage();
            }
        }

        return response()->json($status);
    }

    /**
     * Filter out whitespace and space, create slug 
     *
     * @param  string @string
     */
    private function createSlug($rawInput) 
    {   
        $output = '';
        $output = preg_replace('/\s+/', ' ', $output);
        $output = trim(strtolower($rawInput));
        $output = str_replace(' ', '-', $output);

        return $output;
    }
}
