<?php

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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('/channels/create', 'ChannelsController@create');
    Route::post('/channels', 'ChannelsController@store');
    Route::get('channels/{channel}/edit','ChannelsController@edit');
    Route::patch('channels/{channel}','ChannelsController@update')->name('channels.update');
    Route::delete('/channels/{channel}', 'ChannelsController@destroy')->name('channels.destroy');
});