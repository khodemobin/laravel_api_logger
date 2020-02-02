<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(config('apilog.connection'))->group(function () {
    Route::get('/apilogs', 'LaravelApiLogger\Http\Controllers\ApiLogController@index')->name("apilogs.index");
    Route::delete('/apilogs/delete', 'LaravelApiLogger\Http\Controllers\ApiLogController@deleteAll')->name("apilogs.deletelogs");
});
