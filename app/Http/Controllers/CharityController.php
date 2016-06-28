<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Charity;
use DB;

class CharityController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Returns the charity items json.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        // Query Debugger
        DB::enableQueryLog();
        //dd(DB::getQueryLog());

        // Per page fallback to 10: TODO: Make this from config
        $limit = $request->input('per_page', config('app.global.paging', 10));

        // Use if only needed - 'page' will be detected automagically
        //$offset = $request->input('page', 1);

        // Get query object
        $query = Charity::with('category')->with('tagged');

        // Check for category
        if($category = $request->input('category', false)) {
            $query->where('charity_category_id', $category);
        }

        // Check for charity name
        if($name = $request->input('q', false)) {
            $query->where('name', 'like', '%'.$name.'%');
        }

        // Check for causes
        if($causes = $request->input('cause', false)) {
            $query->withAnyTag([$causes]);
        }

        // Check for lat, lng, radius
        // Filter results only when all the three params are present
        if(($lat = $request->input('lat', false)) && ($lng = $request->input('lng', false)) && ($distance = $request->input('distance', false))) {
            
            $unit = $request->input('unit', 'mile');
            $query->select('*');
            $query->filterByLocationAndDistance($lat, $lng, $distance, $unit);
        }

    	$charities = $query->paginate($limit);
        
    	return response()->json(['items' => $charities]);
    }

    /**
     * Returns the charity item by id as json.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        return response()->json(Charity::with('category')->with('tagged')->findOrFail($id));
    }
}
