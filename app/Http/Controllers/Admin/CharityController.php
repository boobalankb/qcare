<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Charity;
use Caffeinated\Shinobi\Models\Role;
use App\User;

class CharityController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('admin');
    }

    public function index() {

        // do some acl setup
        //$role = Role::create(array('name' => 'Administrator', 'slug' => 'admin'));
        //$role = Role::create(array('name' => 'Donor', 'slug' => 'donor'));

        //$user = User::findOrFail(2);
        //$user->assignRole(2);
        //print_r("<pre>"); print_r($user); print_r("</pre>"); exit;

    	$charities = Charity::all();

        return view('home');    
    }
}
