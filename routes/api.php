<?php

use App\Http\Controllers\DirectoryController;
use App\Http\Middleware\apiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/contact', [DirectoryController::class, 'index'])->middleware('api');
Route::post('/contact', [DirectoryController::class, 'create'])->middleware('api');
Route::put('/contact', [DirectoryController::class, 'update'])->middleware('api');
Route::delete('/contact', [DirectoryController::class, 'destroy'])->middleware('api');