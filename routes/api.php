<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('sidebar-toggle', 'Api\UserApiController@postSidebarToggle');
    Route::post('image-upload', 'Api\UserApiController@postUploadProfilePic');

    Route::group(['middleware' => 'role:admin'], function () {
        Route::post('activate-user', 'Api\UserApiController@postActivateUser');
        Route::post('delete-user', 'Api\UserApiController@postDeleteUser');
        Route::post('delete-role', 'Api\AdminApiController@postDeleteUser');
    });
});