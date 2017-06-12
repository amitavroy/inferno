<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('sidebar-toggle', 'Api\UserApiController@postSidebarToggle');
    Route::post('image-upload', 'Api\UserApiController@postUploadProfilePic');
    Route::get('watchdog-entries', 'Api\UserApiController@getUserWatchdogEntries');

    Route::get('get-media', 'Api\MediaApiController@index');
    Route::post('media-upload', 'Api\MediaApiController@uploadMediaImage');
    Route::post('media/meta-data', 'Api\MediaApiController@imageMetaData');

    Route::group(['middleware' => 'role:admin'], function () {
        Route::post('activate-user', 'Api\UserApiController@postActivateUser');
        Route::post('delete-user', 'Api\UserApiController@postDeleteUser');
        Route::post('delete-role', 'Api\AdminApiController@postDeleteRole');
        Route::post('delete-permission', 'Api\AdminApiController@postDeletePermission');
        Route::get('import-users/{uuid}', 'Api\AdminApiController@importCorrectUsers')->name('import-incomplete-data');
        Route::get('edit-users/{uuid}', 'Api\AdminApiController@editWrongUsersLive');
    });
});