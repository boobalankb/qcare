<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CharityCategory;

class CharityCategoryController extends Controller
{
    /**
     * Returns the charity category items json.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    	return CharityCategory::paginate($request->input('per_page', config('app.global.paging', 10)));
    }
}
