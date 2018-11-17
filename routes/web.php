<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', 'CategoriesController@index')->name('home');
Route::get('/channel/{channel}.html', 'ChannelsController@show')->name('channels.show');

Route::name('topics.')->group(function () {
    Route::get('/topic/{topic}.html', 'TopicsController@show')->name('show');

    Route::middleware('auth')->group(function () {
        Route::get('/{channel}/topic/create', 'TopicsController@create')->name('create');
    });
});

Route::name('report.')->group(function () {
    Route::middleware('role:moderator|administrator')->group(function () {
        Route::get('/reports', 'ReportController@index')->name('index');
        Route::get('/users/{user}/reports', 'ReportController@show')->name('show');
        Route::post('/reports/{report}/ignore', 'ReportController@ignore')->name('ignore');
        Route::post('/reports/{report}/delete', 'ReportController@delete')->name('delete');
    });
});

Route::name('ban.')->group(function () {
    Route::middleware('role:moderator|administrator')->group(function () {
        Route::get('/users/{user}/ban', 'BanController@create')->name('create');
        Route::post('/users/{user}/ban', 'BanController@store')->name('store');
    });
});

// categories
Route::prefix('categories')->group(function () {
    Route::name('categories.')->group(function () {
        Route::middleware('role:administrator')->group(function () {
            Route::get('create', 'CategoriesController@create')->name('create');
            Route::post('', 'CategoriesController@store')->name('store');
            Route::get('{category}/edit','CategoriesController@edit')->name('edit');
            Route::patch('{category}','CategoriesController@update')->name('update');
            Route::delete('{category}', 'CategoriesController@destroy')->name('destroy');
        });
    });
});

// moderators
Route::prefix('moderators')->group(function () {
    Route::name('moderators.')->group(function () {
        Route::middleware('role:administrator')->group(function () {
            Route::get('{category}/create', 'UsersController@createModerator')->name('create');
            Route::post('', 'UsersController@storeModerator')->name('store');
            Route::get('', 'UsersController@listModerators')->name('list');
            Route::delete('{user}/{category}', 'UsersController@destroyModerator')->name('destroy');
        });
    });
});

// channels
Route::prefix('channels')->group(function () {
    Route::name('channels.')->group(function () {
        Route::get('', 'ChannelsController@index')->name('index');

        Route::middleware('role:administrator')->group(function () {
            Route::get('create', 'ChannelsController@create')->name('create');
            Route::post('', 'ChannelsController@store')->name('store');
            Route::get('{channel}/edit','ChannelsController@edit')->name('edit');
            Route::patch('{channel}','ChannelsController@update')->name('update');
            Route::delete('{channel}', 'ChannelsController@destroy')->name('destroy');
        });
    });
});

// topics
Route::prefix('topics')->group(function () {
    Route::name('topics.')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::post('create', 'TopicsController@store')->name('store');
        });

        Route::group(['middleware' => 'can:manage,topic'], function () {
            Route::get('{topic}/edit','TopicsController@edit')->name('edit');
            Route::patch('{topic}','TopicsController@update')->name('update');
            Route::delete('{topic}', 'TopicsController@destroy')->name('destroy');
        });
    });
});

// replies
Route::prefix('replies')->group(function () {
    Route::name('replies.')->group(function () {
        Route::middleware('can:manage,reply')->group(function () {
            Route::get('{reply}/edit','RepliesController@edit')->name('edit');
            Route::patch('{reply}','RepliesController@update')->name('update');
            Route::delete('{reply}', 'RepliesController@destroy')->name('destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::post('topics/{topic}', 'RepliesController@store')->name('replies.store');
    Route::get('/profile/{user}.html', 'UsersController@show')->name('users.show');
});

Route::name('response.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/replies/{reply}', 'RepliesController@createResponse')->name('create');
        Route::post('/replies/{reply}', 'RepliesController@storeResponse')->name('store');
    });
});

// users
Route::prefix('users')->group(function () {
    Route::name('users.')->group(function () {
        Route::get('stats', 'UsersController@stats')->name('stats');

        Route::middleware('can:manage,user')->group(function () {
            Route::get('{user}/edit','UsersController@edit')->name('edit');
            Route::patch('{user}','UsersController@update')->name('update');
            Route::delete('{user}', 'UsersController@destroy')->name('destroy');
        });
    });
});

// report
Route::prefix('report')->group(function () {
    Route::name('report.')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('{reply}', 'ReportController@create')->name('create');
            Route::post('{reply}', 'ReportController@store')->name('store');
        });
    });
});

// pages
Route::name('pages.')->group(function () {
    Route::view('/terms', 'pages.terms')->name('terms');
    Route::view('/policy', 'pages.policy')->name('policy');
});