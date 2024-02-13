<?php

use App\Http\Controllers\DashboardC;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginC;
use App\Http\Controllers\PaketC;
use App\Http\Controllers\TransC;
use App\Http\Controllers\LogC;
use App\Http\Controllers\UsersR;

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
//LOGIN
Route::get('login',[LoginC::class, 'login'])->name('login');
Route::post('login', [LoginC::class, 'login_action'])->name('login.action');
Route::get('logout', [LoginC::class, 'logout'])->middleware('auth');

Route::get('error',[UsersR::class, 'error'])->name('error');

Route::get('/', function () {$subtitle = 'Home Page';return view('login', compact('subtitle'));});
//DASHBOARD
Route::get('dashboard', [DashboardC::class, 'dashboard'])->middleware('userAkses:admin,kasir,owner');



//PAKET
Route::get('paket', [PaketC::class, 'index'])->name('paket.index')->middleware('userAkses:admin,kasir,owner');
Route::get('paket/create', [PaketC::class, 'create'])->name('paket.create')->middleware('userAkses:admin');
Route::post('paket/store', [PaketC::class, 'store'])->name('paket.store')->middleware('userAkses:admin');
Route::get('paket/edit/{id}', [PaketC::class, 'edit'])->name('paket.edit')->middleware('userAkses:admin');
Route::put('paket/update/{id}', [PaketC::class, 'update'])->name('paket.update')->middleware('userAkses:admin');
Route::delete('paket/destroy/{id}', [PaketC::class, 'destroy'])->name('paket.destroy')->middleware('userAkses:admin');
Route::get('paket/pdf', [PaketC::class, 'pdf'])->name('paket.pdf')->middleware('userAkses:admin');



//TRANSAKSI
Route::get('transactions', [TransC::class, 'index'])->name('transactions.index')->middleware('userAkses:owner,kasir,admin');
Route::get('transactions/create', [TransC::class, 'create'])->name('transactions.create')->middleware('userAkses:kasir');
Route::post('transactions/store', [TransC::class, 'store'])->name('transactions.store')->middleware('userAkses:kasir');
Route::get('transactions/edit/{id}', [TransC::class, 'edit'])->name('transactions.edit')->middleware('userAkses:admin');
Route::put('transactions/update/{id}', [TransC::class, 'update'])->name('transactions.update')->middleware('userAkses:admin');
Route::delete('transactions/destroy/{id}', [TransC::class, 'destroy'])->name('transactions.destroy')->middleware('userAkses:admin');
Route::get('transactions/struk/{id}', [TransC::class,'struk'])->name('transactions.struk')->middleware('userAkses:kasir');
Route::get('transactions/pdf', [TransC::class, 'pdf'])->name('transactions.pdf')->middleware('userAkses:owner');
Route::get('/transactions/pdfFilter', [TransC::class, 'pdfFilter'])->name('transactions.pdfFilter')->middleware('userAkses:owner');



//USER 
Route::get('users/pdf', [UsersR::class, 'pdf'])->name('users.pdf')->middleware('userAkses:admin');
Route::resource('users', UsersR::class)->middleware('userAkses:admin');
Route::get('users/changepassword/{id}', [UsersR::class, 'changepassword'])->name('users.changepassword')->middleware('userAkses:admin');
Route::put('users/change/{id}', [UsersR::class, 'change'])->name('users.change')->middleware('userAkses:admin');
Route::delete('users/destroy/{id}', [UsersR::class, 'destroy'])->name('users.destroy')->middleware('userAkses:admin');


//LOG
Route::get('log', [LogC::class, 'index'])->name('log.index')->middleware('userAkses:owner');
Route::get('/log/filter', [LogC::class, 'filter'])->name('log.filter')->middleware('userAkses:owner');




