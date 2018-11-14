<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/{channel}/topic/create', 'TopicsController@create')->name('topics.create');
    Route::post('/topic/create', 'TopicsController@store')->name('topics.store');
    Route::post('/topic/{topic}', 'RepliesController@store')->name('replies.store');
    Route::post('/replies/{reply}', 'RepliesController@storeResponse')->name('response.store');
    Route::get('/replies/{reply}', 'RepliesController@createResponse')->name('response.create');
    Route::get('/user/{user}', 'UsersController@show')->name('users.show');
    Route::get('/report/{reply}', 'ReportController@create')->name('report.create');
    Route::post('/report/{reply}', 'ReportController@store')->name('report.store');
});

Route::group(['middleware' => 'can:manage,user'], function () {
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
Route::get('users/{user}/edit','UsersController@edit')->name('users.edit');
Route::patch('users/{user}','UsersController@update')->name('users.update');
});

Route::group(['middleware' => 'can:manage,topic'], function () {
Route::get('topics/{topic}/edit','TopicsController@edit')->name('topics.edit');
Route::patch('topics/{topic}','TopicsController@update')->name('topics.update');
Route::delete('/topics/{topic}', 'TopicsController@destroy')->name('topics.destroy');
});

Route::group(['middleware' => 'can:manage,reply'], function () {
Route::get('replies/{reply}/edit','RepliesController@edit')->name('replies.edit');
Route::patch('replies/{reply}','RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
});

Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('/channels/create', 'ChannelsController@create')->name('channels.create');
    Route::post('/channels', 'ChannelsController@store')->name('channels.store');
    Route::get('channels/{channel}/edit','ChannelsController@edit')->name('channels.edit');
    Route::patch('channels/{channel}','ChannelsController@update')->name('channels.update');
    Route::delete('/channels/{channel}', 'ChannelsController@destroy')->name('channels.destroy');
    Route::get('/categories/create', 'CategoriesController@create')->name('categories.create');
    Route::post('/categories', 'CategoriesController@store')->name('categories.store');
    Route::get('categories/{category}/edit','CategoriesController@edit')->name('categories.edit');
    Route::patch('categories/{category}','CategoriesController@update')->name('categories.update');
    Route::delete('/categories/{category}', 'CategoriesController@destroy')->name('categories.destroy');
    Route::get('/moderators/{category}/create', 'UsersController@createModerator')->name('moderators.create');
    Route::post('/moderators', 'UsersController@storeModerator')->name('moderators.store');
    Route::get('/moderators', 'UsersController@listModerators')->name('moderators.list');
    Route::delete('/moderators/{user}/{category}', 'UsersController@destroyModerator')->name('moderators.destroy');
});

Route::group(['middleware' => ['role:administrator|moderator']], function () {
    Route::get('/reports', 'ReportController@index')->name('report.index');
    Route::get('/users/{user}/reports', 'ReportController@show')->name('report.show');
    Route::get('/users/{user}/ban', 'BanController@create')->name('ban.create');
    Route::post('/users/{user}/ban', 'BanController@store')->name('ban.store');
    Route::post('/reports/{report}/ignore', 'ReportController@ignore')->name('report.ignore');
    Route::post('/reports/{report}/delete', 'ReportController@delete')->name('report.delete');
});


Route::get('/channels', 'ChannelsController@index')->name('channels.index');
Route::get('/channels/{channel}', 'ChannelsController@show')->name('channels.show');
Route::get('/topic/{topic}', 'TopicsController@show')->name('topics.show');
Route::view('/terms', 'pages.terms')->name('pages.terms');
Route::view('/policy', 'pages.policy')->name('pages.policy');
Route::get('/users/stats', 'UsersController@stats')->name('users.stats');
Route::get('/', 'CategoriesController@index')->name('home');
Route::get('/categories/{category}', 'CategoriesController@show')->name('categories.show');

