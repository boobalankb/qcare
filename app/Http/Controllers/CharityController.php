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

    public function index() {

    	$charities = Charity::all();
    	return response()->json(['items' => $charities]);
    }

    public function CategoryId($id) {

         $charities = Charity::findOrFail($id);
         return response()->json(['items' => $charities]);
    }

     public function Categoryname($cat_name) {
        
        $users = DB::table('Charity')
                    ->where('name', $cat_name)
                    ->get();
        return response()->json(['items' => $users]);
       
    }



}
