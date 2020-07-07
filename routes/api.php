<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Middleware
//// admin

// Authentication API's
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','api\Auth\AuthController@Login');
    Route::post('/register','api\Auth\AuthController@Register');
    Route::post('/reset','api\Auth\AuthController@Reset');
    Route::get('/me','api\Auth\AuthController@Me')->middleware('admin');
    Route::post('/logout','api\Auth\AuthController@Logout');
});


// Building API's
Route::group(['prefix' => 'building', 'middleware' => ['admin']], function () {
    Route::apiResource('/building','api\Building\BuildingController');
    Route::apiResource('/floor','api\Building\FloorController');
    Route::apiResource('/room','api\Building\RoomController');
});

// Student API's
Route::group(['prefix' => 'student', 'middleware' => ['admin']], function () {
    Route::apiResource('/student','api\Student\StudentController');
    Route::apiResource('/payment','api\Payment\PaymentController');
});

// Guest API's
Route::group(['prefix' => 'guest', 'middleware' => ['admin']], function () {
    Route::apiResource('/guest','api\Guest\GuestController');
});