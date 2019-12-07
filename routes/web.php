<?php

Auth::routes();

Route::get('/', 'IPController@index');

Route::get('/add/ip', 'IPController@addIPForm');

Route::post('/ip', 'IPController@addIP');

Route::get('/ip', 'IPController@findIP');

Route::get('/reports/', 'IPController@showIPStats');

Route::get('/reports/{month}', 'IPController@showIPStats');

Route::get('/ip/{ip}', 'IPController@getIPStats');

Route::get('/ip/{ip}/{month}', 'IPController@getIPStats');

Route::get('/visual/{ip}', 'IPController@getVisualStats');

Route::get('/register', function(){abort(404);});

Route::group(['middleware' => ['auth']] , function(){

    Route::get('/dashboard', 'AdminController@viewIPs');

    Route::get('/logout', 'Auth\LoginController@logout');

});