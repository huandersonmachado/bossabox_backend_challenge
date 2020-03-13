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

Route::group(['prefix' => 'tools'], function() {
    Route::get('/', 'ToolsController@index')->name('tools.index');
    Route::post('/', 'ToolsController@store')->name('tools.store');
    Route::delete('{id}', 'ToolsController@delete')->name('tools.delete');
});
