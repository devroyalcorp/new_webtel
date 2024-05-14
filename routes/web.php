<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\WebmailController;
use App\Http\Controllers\WebtelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/webmail', [WebmailController::class, 'index'])->name('webmail.index');
Route::get('/webtel', [WebtelController::class, 'index'])->name('webtel.index');

