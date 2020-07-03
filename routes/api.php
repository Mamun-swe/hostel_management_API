<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Authentication API's
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','api\Auth\AuthController@Login');
    Route::post('/register','api\Auth\AuthController@Register');
    Route::post('/reset','api\Auth\AuthController@Reset');
    Route::get('/me/{id}','api\Auth\AuthController@Me');
    Route::post('/logout','api\Auth\AuthController@Logout');
});


// Building API's
Route::group(['prefix' => 'building'], function () {
    Route::apiResource('/building','api\Building\BuildingController');
    Route::apiResource('/floor','api\Building\FloorController');
    Route::apiResource('/room','api\Building\RoomController');
});

// Student API's
Route::group(['prefix' => 'student'], function () {
    Route::apiResource('/student','api\Student\StudentController');
    Route::apiResource('/payment','api\Payment\PaymentController');
});