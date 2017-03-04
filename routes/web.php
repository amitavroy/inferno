<?php

Route::get('test', function () {
    $data = \App\User::find(2);
    $redis = \LRedis::connection();
    $redis->publish('message', $data);
});

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

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('config', ['as' => 'config', 'uses' => 'AdminController@getConfigPage']);
        Route::get('config/system/activities', ['as' => 'activities', 'uses' => 'WatchdogController@getWatchdogPage']);
        Route::get('config/system/settings', ['as' => 'settings', 'uses' => 'AdminController@getSettingsPage']);
        Route::post('config/system/settings', ['as' => 'settings-save', 'uses' => 'AdminController@postHandleSettingsPageSave']);
        Route::post('config/system/settings-add', ['as' => 'settings-add', 'uses' => 'AdminController@postHandleSettingsPageAdd']);

        Route::get('config/user/roles', ['as' => 'manage-roles', 'uses' => 'AdminController@getManageRoles']);
        Route::post('config/user/role-save', ['as' => 'save-role', 'uses' => 'AdminController@postSaveRoles']);
        Route::get('config/user/roles/{id}', ['as' => 'edit-role', 'uses' => 'AdminController@getEditRole']);
        Route::post('config/user/role/update', ['as' => 'update-role', 'uses' => 'AdminController@postUpdateRole']);
    });
});