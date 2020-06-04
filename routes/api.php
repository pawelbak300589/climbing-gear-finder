<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function ()
{
    echo 'Welcome to our API';
});

Route::group(['prefix' => 'auth'], function ()
{
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');

    Route::group(['middleware' => 'auth:api'], function ()
    {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function ()
{
    Route::group(['prefix' => 'users'], function ()
    {
        Route::get('/', 'Api\Admin\UsersController@index');
        Route::post('/', 'Api\Admin\UsersController@store');
        Route::get('/{id}', 'Api\Admin\UsersController@show');
        Route::put('/{id}', 'Api\Admin\UsersController@update');
        Route::patch('/{id}', 'Api\Admin\UsersController@update');
        Route::delete('/{id}', 'Api\Admin\UsersController@destroy');
    });

    Route::group(['prefix' => 'roles'], function ()
    {
        Route::get('/', 'Api\Admin\RolesController@index');
        Route::post('/', 'Api\Admin\RolesController@store');
        Route::get('/{id}', 'Api\Admin\RolesController@show');
        Route::put('/{id}', 'Api\Admin\RolesController@update');
        Route::patch('/{id}', 'Api\Admin\RolesController@update');
        Route::delete('/{id}', 'Api\Admin\RolesController@destroy');
    });

    Route::group(['prefix' => 'brands'], function ()
    {
        Route::get('/', 'Api\Admin\BrandsController@index');
        Route::post('/', 'Api\Admin\BrandsController@store');
        Route::get('/{id}', 'Api\Admin\BrandsController@show');
        Route::patch('/{id}', 'Api\Admin\BrandsController@update');
        Route::delete('/{id}', 'Api\Admin\BrandsController@destroy');
        Route::post('/blacklist/{id}', 'Api\Admin\BrandsController@blacklist');
        Route::post('/convert/{id}/to/{parentId}', 'Api\Admin\BrandsController@moveToMapping');
        Route::get('/{id}/mappings', 'Api\Admin\BrandsController@mappings');
    });
});
