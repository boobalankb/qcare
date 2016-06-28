<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CharityCategory;
use Auth;

class CharityCategoryController extends Controller
{
    protected $guard = 'admin';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CharityCategory::paginate(10);
        $guard = $this->guard;
        return view('admin.categories.index', compact('categories', 'guard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create', ['category' => new \App\CharityCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new CharityCategory;

        $this->validate($request, [
            'name' => 'required|unique:charity_categories|max:255'
        ]);

        $category->name = $request->input('name', '');

        if($category->save()) {
            $request->session()->flash('message', 'Category saved successfully!');
            $request->session()->flash('message-class', 'alert-success');
            return redirect('/admin/category');
        }
        else {
            $request->session()->flash('message', 'Error processing request');
            $request->session()->flash('message-class', 'alert-error');
            return view('admin.categories.create', ['category' => new \App\CharityCategory, 'categories' => $categories]);
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
        $category = CharityCategory::findOrFail($id);
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = CharityCategory::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $category->name = $request->input('name', '');

        if($category->save()) {
            $request->session()->flash('message', 'Category saved successfully!');
            $request->session()->flash('message-class', 'alert-success');
            return redirect('/admin/category');
        }
        else {
            $request->session()->flash('message', 'Oops, not saved!');
            $request->session()->flash('message-class', 'alert-error');
            return view('admin.categories.edit', ['category' => $category]);
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
