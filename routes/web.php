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

Route::get('/', 'ChannelsController@index')->name('home');
Route::get('/channels/{channel}', 'ChannelsController@show')->name('channels.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/topic/create', 'TopicsController@create')->name('topics.create');
    Route::post('/topic/create', 'TopicsController@store')->name('topics.store');
    Route::post('/topic/{topic}', 'RepliesController@store')->name('replies.store');
    Route::post('/replies/{reply}', 'RepliesController@storeResponse')->name('response.store');
    Route::get('/replies/{reply}', 'RepliesController@createResponse')->name('response.create');
    Route::get('/user/{user}', 'UsersController@show')->name('users.show');
});

Route::get('/topic/{id}', 'TopicsController@show')->name('topics.show');

Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('/channels/create', 'ChannelsController@create');
    Route::post('/channels', 'ChannelsController@store');
    Route::get('channels/{channel}/edit','ChannelsController@edit');
    Route::patch('channels/{channel}','ChannelsController@update')->name('channels.update');
    Route::delete('/channels/{channel}', 'ChannelsController@destroy')->name('channels.destroy');
    Route::get('topics/{topic}/edit','TopicsController@edit')->name('topics.edit');
    Route::patch('topics/{topic}','TopicsController@update')->name('topics.update');
    Route::delete('/topics/{topic}', 'TopicsController@destroy')->name('topics.destroy');
});

Route::group(['middleware' => ['role:administrator|moderator']], function () {
    Route::get('replies/{reply}/edit','RepliesController@edit')->name('replies.edit');
    Route::patch('replies/{reply}','RepliesController@update')->name('replies.update');
    Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
});