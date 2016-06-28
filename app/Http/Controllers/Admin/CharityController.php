<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Charity;
use App\Http\Requests\StoreCharityRequest;
use DB;
use Auth;

class CharityController extends Controller
{

    protected $guard = 'admin';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charities = Charity::with('category')->paginate(10);
        $guard = $this->guard;
        return view('admin.charities.index', compact('charities', 'guard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('charity_categories')->pluck('name', 'id');
        return view('admin.charities.create', ['charity' => new \App\Charity, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCharityRequest $request)
    {
        $charity = new Charity;

        // fillable inputs
        $columnMap = ['name', 'charity_category_id', 'address', 'state', 'country', 'zip', 'phone', 'email', 'latitude', 'longitude', 'contact_person', 'size', 'description', 'certification', 'authentication'];
        
        foreach($columnMap as $column) {
            $charity->$column = $request->input($column, '');
        }

        if($charity->save()) {
            $request->session()->flash('success', 'Charity saved successfully!');
            return redirect('/admin/charities');
        }
        else {
            $request->session()->flash('error', 'Error processing request');
            $categories = DB::table('charity_categories')->pluck('name', 'id');
            return view('admin.charities.create', ['charity' => new \App\Charity, 'categories' => $categories]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $charity = Charity::with('category')->findOrFail($id);
        $causes = [];
        foreach($charity->tags as $tag) {
            $causes[] = $tag->name;
        }
        $charity->causes = implode('|', $causes);
        $categories = DB::table('charity_categories')->pluck('name', 'id');
        $guard = $this->guard;
        return view('admin.charities.edit', compact('charity', 'guard', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharityRequest $request, $id)
    {
        $charity = Charity::with('category')->findOrFail($id);

        // fillable inputs
        $columnMap = ['name', 'charity_category_id', 'address', 'state', 'country', 'zip', 'phone', 'email', 'latitude', 'longitude', 'contact_person', 'size', 'description', 'certification', 'authentication'];
        
        foreach($columnMap as $column) {
            $charity->$column = $request->input($column, '');
        }

        $charity->retag(explode('|', $request->input('causes', '')));

        if($charity->save()) {
            $request->session()->flash('success', 'Charity saved successfully!');
            return redirect('/admin/charities');
        }
        else {
            $request->session()->flash('error', 'Error processing request');
            $categories = DB::table('charity_categories')->pluck('name', 'id');
            return view('admin.charities.create', ['charity' => new \App\Charity, 'categories' => $categories]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
