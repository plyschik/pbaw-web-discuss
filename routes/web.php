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

Route::get('/', 'TopicsController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/topic/create', 'TopicsController@create')->name('topics.create');
    Route::post('/topic/create', 'TopicsController@store')->name('topics.store');
    Route::post('/topic/{topic}', 'RepliesController@store')->name('replies.store');
});

Route::get('/topic/{id}', 'TopicsController@show')->name('topics.show');

Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('/channels/create', 'ChannelsController@create');
    Route::post('/channels', 'ChannelsController@store');
    Route::get('channels/{channel}/edit','ChannelsController@edit');
    Route::patch('channels/{channel}','ChannelsController@update')->name('channels.update');
    Route::delete('/channels/{channel}', 'ChannelsController@destroy')->name('channels.destroy');
});

Route::group(['middleware' => ['role:administrator|moderator']], function () {
    Route::get('replies/{reply}/edit','RepliesController@edit')->name('replies.edit');
    Route::patch('replies/{reply}','RepliesController@update')->name('replies.update');
});