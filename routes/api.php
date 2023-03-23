<?php

use App\Http\Controllers\DateController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user',function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');

Route::get('error403',function(Request $request){
    return response()->json([
        'msg' => 'invlied token'
    ]);
})->name('login');

Route::post('login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/set_dates', [DateController::class, 'setDates']);
    Route::get('/dates', [DateController::class, 'getDates']);
    Route::get('/get-moderators', [ModeratorController::class, 'getAllModerators']);
    Route::post('/add-moderator', [ModeratorController::class, 'addModerator']);
    Route::post('/edit-moderator', [ModeratorController::class, 'editModerator']);
    Route::post('/remove-moderator', [ModeratorController::class, 'removeModerator']);
    Route::get('/get-years', [YearController::class, 'getYears']);
});
