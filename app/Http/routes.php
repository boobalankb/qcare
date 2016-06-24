<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	//'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Route::auth();

Route::group(['prefix' => '/admin'], function () {
    //Login Routes...
    $this->get('/login','Admin\AuthController@showLoginForm');
    $this->post('/login','Admin\AuthController@login');
    $this->get('/logout','Admin\AuthController@logout');

    // Registration Routes...
    //Route::get('/register', 'Admin\AuthController@showRegistrationForm');
    //Route::post('/register', 'Admin\AuthController@register');

    Route::get('/', 'Admin\CharityController@index');

    Route::group([
        'middleware' => ['admin', 'admin.ability:admin'],
    ], function () {
        Route::get('/charities', 'Admin\CharityController@index');
    });
});

Route::get('/home', 'HomeController@index');


// API Endpoint routes v1
Route::group([
    'prefix' => 'api/v1'
], function () {

    // Auth Registration, Login routes
	$this->post('register', 'Auth\AuthApiController@register');
    $this->post('login', 'Auth\AuthApiController@login');
    $this->get('logout', ['middleware' => ['ability:donor'], 'uses'=>'Auth\AuthApiController@logout']);

    // password reset
    /*$this->post('password/email', 'Auth\PasswordApiController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordApiController@reset');
    $this->get('password/reset/{token?}', 'Auth\PasswordApiController@showResetForm');*/

    // simple password reset
    $this->post('password/reset', 'Auth\PasswordApiController@simpleReset');

    // Donor bound routes
    Route::group([
        'middleware' => ['ability:donor'],
    ], function () {
        Route::get('/charities', 'CharityController@index');
        Route::get('/index', 'HomeController@index');
    });
});