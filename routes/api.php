<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public Routes
app('router')->group([], function() {
    app('router')->post('/auth/signup', [
        'as' => 'auth.signup',
        'uses' => 'AuthController@signup'
    ]);

    app('router')->post('/auth/signin', [
        'as' => 'auth.signin',
        'uses' => 'AuthController@signin'
    ]);

    app('router')->get('/sections', [
        'as' => 'sections.index',
        'uses' => 'Forum\SectionController@index'
    ]);
});


//Private Routes
app('router')->group(['middleware' => ['auth:api']], function() {
    app('router')->get('/auth/user', [
        'as' => 'user.index',
        'uses' => 'UserController@index',
    ]);
});