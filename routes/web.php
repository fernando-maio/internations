<?php


Route::get('/', 'PageController@index')->name('login');
Route::post('/', 'PageController@login')->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@list')->name('users.list');
        Route::get('/create', 'UserController@getCreate')->name('users.create');
        Route::post('/create', 'UserController@postCreate')->name('users.create');
        Route::get('/edit/{id}', 'UserController@getEdit')->name('users.edit');
        Route::post('/edit/{id}', 'UserController@postEdit')->name('users.edit');
        Route::get('/remove/{id}', 'UserController@remove')->name('users.remove');
    });

    Route::group(['middleware' => 'master', 'prefix' => 'groups'], function () {
        Route::get('/', 'GroupController@list')->name('groups.list');
        Route::get('/create', 'GroupController@getCreate')->name('groups.create');
        Route::post('/create', 'GroupController@postCreate')->name('groups.create');
        Route::get('/edit/{id}', 'GroupController@getEdit')->name('groups.edit');
        Route::post('/edit/{id}', 'GroupController@postEdit')->name('groups.edit');
        Route::get('/remove/{id}', 'GroupController@remove')->name('groups.remove');
    });

    Route::get('/logout', function() {
        Auth::logout();
        return Redirect::to('/');
    })->name('logout');
});