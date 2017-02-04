<?php

Route::get('/', function () {return view('adminlte.pages.login');});
Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'UserController@pageDashboard']);

Route::group(['middleware' => 'auth'], function () {

});