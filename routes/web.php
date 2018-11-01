<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/topic/create', 'TopicsController@create')->name('topics.create');
    Route::post('/topic/create', 'TopicsController@store')->name('topics.store');
    Route::post('/topic/{topic}', 'RepliesController@store')->name('replies.store');
    Route::post('/replies/{reply}', 'RepliesController@storeResponse')->name('response.store');
    Route::get('/replies/{reply}', 'RepliesController@createResponse')->name('response.create');
    Route::get('/user/{user}', 'UsersController@show')->name('users.show');
    Route::get('/report/{reply}', 'ReportController@create')->name('report.create');
    Route::post('/report/{reply}', 'ReportController@store')->name('report.store');
    Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
    Route::get('users/{user}/edit','UsersController@edit')->name('users.edit');
    Route::patch('users/{user}','UsersController@update')->name('users.update');
});

Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('/channels/create', 'ChannelsController@create')->name('channels.create');
    Route::post('/channels', 'ChannelsController@store')->name('channels.store');
    Route::get('channels/{channel}/edit','ChannelsController@edit')->name('channels.edit');
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
    Route::get('/reports', 'ReportController@index')->name('report.index');
    Route::get('/reports/{report}', 'ReportController@show')->name('report.show');
    Route::post('/reports/{report}/ignore', 'ReportController@ignore')->name('report.ignore');
    Route::post('/reports/{report}/delete', 'ReportController@delete')->name('report.delete');
    Route::delete('/reports/{report}', 'ReportController@destroy')->name('report.destroy');
});


Route::get('/', 'ChannelsController@index')->name('home');
Route::get('/channels/{channel}', 'ChannelsController@show')->name('channels.show');
Route::get('/topic/{id}', 'TopicsController@show')->name('topics.show');
Route::view('/terms', 'pages.terms')->name('pages.terms');
Route::view('/policy', 'pages.policy')->name('pages.policy');