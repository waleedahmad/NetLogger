<?php

Route::get('/', 'IPController@index');

Route::get('/add/ip', 'IPController@addIPForm');

Route::post('/ip', 'IPController@addIP');

Route::get('/ip', 'IPController@findIP');

Route::get('/ip/{ip}', 'IPController@getIPStats');
