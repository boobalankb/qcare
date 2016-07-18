<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Conner\Tagging\Model\Tag;

class CharityCauseController extends Controller
{
    /**
     * Returns the causes tag list as json.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return response()->json(\Conner\Tagging\Model\Tag::get());
    }
}
