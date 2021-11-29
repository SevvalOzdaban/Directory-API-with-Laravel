<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\SendEmailController;
use App\Mail\SendMail;
use App\Models\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Mail;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [ClientController::class, 'index'])->middleware('auth')->name('index');
Route::post('/client', [ClientController::class, 'create'])->name('create');
Route::post('/sendMail', [ClientController::class, 'create'])->name('create');
Route::post('/edit', [ClientController::class, 'edit']);
require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
