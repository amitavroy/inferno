<?php

Route::get('/', function () {return view('adminlte.pages.login');});
Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);

if (\Setting::get('user_can_register')) {
    Route::get('register', ['as' => 'register', 'uses' => 'UserController@getRegistrationPage']);
    Route::post('do-register', ['as' => 'do-register', 'uses' => 'UserController@postHandleUserRegistration']);
}

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UserController@pageDashboard']);
    Route::post('do-logout', ['as' => 'logout', 'uses' => 'UserController@postLogout']);
    Route::get('user/profile', ['as' => 'profile', 'uses' => 'UserController@pageUserProfile']);
    Route::post('user/profile', ['as' => 'update-profile', 'uses' => 'UserController@postUpdateProfile']);
    Route::get('config/activities', ['as' => 'activities', 'uses' => 'WatchdogController@getWatchdogPage']);
    Route::get('config/settings', ['as' => 'settings', 'uses' => 'UserController@getSettingsPage']);
});