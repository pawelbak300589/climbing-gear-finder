<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function ()
{
    // https://docs.spatie.be/laravel-permission/v3/basic-usage/
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    Route::get('/users', 'UsersController@index')->name('admin.users');
    Route::get('/users/create', 'UsersController@create')->name('admin.users.create');
    Route::get('/users/{user}', 'UsersController@show');
    Route::get('/users/{user}/edit', 'UsersController@edit');
    Route::post('/users', 'UsersController@store')->name('admin.users.store');
    Route::patch('/users/{user}', 'UsersController@update');
    Route::delete('/users/{user}', 'UsersController@destroy');

    Route::get('/brands', 'BrandsController@index')->name('admin.brands');
});
