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

//Route::get('/', 'WelcomeController@index');

Route::get('/', 'MainController@departmentSelector');

Route::post('/process', 'ProcessController@departmentProcess');

Route::post('/report-process', 'ProcessController@departmentReportProcess');

Route::get('home', 'HomeController@index');

Route::get('/central', 'MainController@centralPageController');

Route::get('/theMall', 'MainController@theMallPageController');

Route::get('/lotus', 'MainController@lotusPageController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::filter('csrf', function($route, $request) {
    if (strtoupper($request -> getMethod()) === 'GET') {
        return;
        // get requests are not CSRF protected
    }

    $token = $request -> ajax() ? $request -> header('X-CSRF-Token') : Input::get('_token');

    error_log($token);
    
    if (Session::token() != $token) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});