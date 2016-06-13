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
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/charities', 'Admin\CharityController@index');

Route::group([
    'prefix' => 'api/v1'
], function () {

	$this->post('register', 'Auth\AuthController@register');
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout', 'Auth\AuthController@logout');

    Route::group([
        'middleware' => 'apiauth:api',
    ], function () {

        Route::get('/charities', 'CharityController@index');

        Route::get('/index', 'HomeController@index');
    });
});