<?php

Route::get('/', function () {return view('adminlte.pages.login');});
Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);
Route::get('forgot-password', function () {return view('adminlte.pages.forgot-password');});
Route::post('forgot-password/send', ['as' => 'forgot-password-send', 'uses' => 'UserController@postForgotPassword']);
Route::get('forgot-password/set/{token}', ['as' => 'set-forgot-password', 'uses' => 'UserController@getSetForgotPassword']);
Route::post('forgot-password/update', ['as' => 'update-forgot-password', 'uses' => 'UserController@postSetForgotPassword']);

/*Urls based on functionality of User can register*/
if (\Setting::get('user_can_register')) {
    Route::get('register', ['as' => 'register', 'uses' => 'UserController@getRegistrationPage']);
    Route::post('do-register', ['as' => 'do-register', 'uses' => 'UserController@postHandleUserRegistration']);
    Route::get('config/user/activation-pending', [
        'middleware' => 'auth',
        'as' => 'user-activation-pending',
        'uses' => 'AdminController@getUserActivationPending'
    ]);
}

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UserController@pageDashboard']);
    Route::post('do-logout', ['as' => 'logout', 'uses' => 'UserController@postLogout']);
    Route::get('user/profile', ['as' => 'profile', 'uses' => 'UserController@pageUserProfile']);
    Route::post('user/profile', ['as' => 'update-profile', 'uses' => 'UserController@postUpdateProfile']);
    Route::post('user/password-change', ['as' => 'change-password', 'uses' => 'UserController@postHandlePasswordChange']);
    Route::get('config', ['as' => 'config', 'uses' => 'AdminController@getConfigPage']);
    Route::get('config/system/activities', ['as' => 'activities', 'uses' => 'WatchdogController@getWatchdogPage']);
    Route::get('config/system/settings', ['as' => 'settings', 'uses' => 'AdminController@getSettingsPage']);
    Route::post('config/system/settings', ['as' => 'settings-save', 'uses' => 'AdminController@postHandleSettingsPageSave']);
    Route::post('config/system/settings-add', ['as' => 'settings-add', 'uses' => 'AdminController@postHandleSettingsPageAdd']);
});