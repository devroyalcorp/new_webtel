<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoghistoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebmailController;
use App\Http\Controllers\WebtelController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserSession;

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


//webmail old (if want to use again this controller just uncomment this and all .old and .bak file)
// Route::get('/', [IndexController::class, 'index'])->name('home');
// Route::get('/webmail', [WebmailController::class, 'index'])->name('webmail.index');
// Route::get('/webmail/companies/{id}', [WebmailController::class, 'detail_webmail'])->name('webmail.detail');
// Route::get('/webmail/datatables/{id}', [WebmailController::class, 'datatables_webmail'])->name('webmail.datatables');
// Route::get('/webmail/get_employee_webmail/{id}', [WebmailController::class, 'get_employee_webmail'])->name('webmail.get_employee_webmail');
// Route::post('/webmail/update_webmail', [WebmailController::class, 'update'])->name('webmail.update');

Route::middleware(['web', CheckUserSession::class])->group(function () {
    // webtel
    Route::get('/', [WebtelController::class, 'index'])->name('webtel.index');
    Route::get('/webtel/companies/{id}', [WebtelController::class, 'detail_webtel'])->name('webtel.detail');
    Route::get('/webtel/datatables/{id}', [WebtelController::class, 'datatables_webtel'])->name('webtel.datatables');
    Route::get('/webtel/get_employee_webtel/{id}', [WebtelController::class, 'get_employee_webtel'])->name('webtel.get_employee_webtel');
    Route::post('/webtel/update_webtel', [WebtelController::class, 'update'])->name('webtel.update');
    Route::post('/webtel/set_primary_emails', [WebtelController::class, 'set_primary_emails'])->name('webtel.set_primary_emails');
    Route::get('/webtel/showEmails/{id}', [WebtelController::class, 'showEmails'])->name('webtel.showEmails');

    // for log
    Route::get('/webtel/datatables_loghistory/{id}', [LoghistoriesController::class, 'datatables_loghistory'])->name('webtel.datatables_loghistory');
    Route::get('/webtel/check_history/{id}', [LoghistoriesController::class, 'check_history'])->name('webtel.check_history');
});

//for admin
Route::get('/login', [UserController::class, 'index'])->name('admin.login');
Route::post('/login/checked', [UserController::class, 'login'])->name('admin.logincheck');
Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');

Route::get('/login/keycloak', [UserController::class, 'redirectToKeycloak'])->name('login.keycloak');
Route::get('/login/keycloak/callback', [UserController::class, 'handleKeycloakCallback'])->name('login.keyCloackCallback');
