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

// webtel
Route::get('/webtel', [WebtelController::class, 'index'])->name('webtel.index');
Route::get('/webtel/companies/{id}', [WebtelController::class, 'detail_webtel'])->name('webtel.detail');

//for admin
Route::get('/login', [UserController::class, 'index'])->name('admin.login');
Route::post('/login/checked', [UserController::class, 'login'])->name('admin.logincheck');


//agenda perkara
// Route::post('/perkara/create_agenda_perkara', 'AgendaPerkaraController@create_agenda_perkara')->name('agenda_perkara.create');
// Route::get('/perkara/get_agenda_perkara/{id}', 'AgendaPerkaraController@get_agenda_perkara')->name('agenda_perkara.get_data');
// Route::post('/perkara/update_agenda_perkara', 'AgendaPerkaraController@update_agenda_perkara')->name('agenda_perkara.update');
// Route::post('/perkara/delete_agenda_perkara', 'AgendaPerkaraController@delete_agenda_perkara')->name('agenda_perkara.delete');

