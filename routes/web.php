<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
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

//webmail
Route::get('/webmail', [WebmailController::class, 'index'])->name('webmail.index');
Route::get('/webmail/companies/{id}', [WebmailController::class, 'detail_webmail'])->name('webmail.detail');
Route::get('/webmail/datatables/{id}', [WebmailController::class, 'datatables_webmail'])->name('webmail.datatables');
Route::get('/webmail/get_employee_webmail/{id}', [WebmailController::class, 'get_employee_webmail'])->name('webmail.get_employee_webmail');
Route::post('/webmail/update_webmail', [WebmailController::class, 'update'])->name('webmail.update');


// webtel
Route::get('/webtel', [WebtelController::class, 'index'])->name('webtel.index');
Route::get('/webtel/companies/{id}', [WebtelController::class, 'detail_webtel'])->name('webtel.detail');
Route::get('/webtel/datatables/{id}', [WebtelController::class, 'datatables_webtel'])->name('webtel.datatables');
Route::get('/webtel/get_employee_webtel/{id}', [WebtelController::class, 'get_employee_webtel'])->name('webtel.get_employee_webtel');
Route::post('/webtel/update_webtel', [WebtelController::class, 'update'])->name('webtel.update');

//for admin
Route::get('/login', [UserController::class, 'index'])->name('admin.login');
Route::post('/login/checked', [UserController::class, 'login'])->name('admin.logincheck');
Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');


