<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function ()
{
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/brands', 'BrandsController@index')->name('admin.brands');
});
