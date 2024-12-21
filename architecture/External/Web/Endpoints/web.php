<?php

use Architecture\External\Web\Controller\AccountController;
use Architecture\External\Web\Controller\AuthController;
use Architecture\External\Web\Controller\DashboardController;
use Architecture\External\Web\Controller\DokumenIndukController;
use Architecture\External\Web\Controller\MatriksController;
use Architecture\External\Web\Controller\PenilaianController;
use Architecture\External\Web\Controller\UserController;
use Architecture\Shared\Facades\CheckSession;
// use Architecture\External\Web\Controller\PembobotanPKMController;
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
Route::get('/', [AuthController::class, 'Authorization'])->name('auth.authorization');
Route::post('login', [AuthController::class, 'Authentication'])->name('auth.authentication');
Route::get('logout', [AuthController::class, 'Logout'])->name('auth.logout');

Route::middleware([CheckSession::class])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('matriks', [MatriksController::class, 'index'])->name('matriks.index');
    Route::get('matriks/create', [MatriksController::class, 'create'])->name('matriks.create');
    Route::post('matriks/store', [MatriksController::class, 'store'])->name('matriks.store');
    Route::get('matriks/edit/{id}', [MatriksController::class, 'edit'])->name('matriks.edit');
    Route::post('matriks/update', [MatriksController::class, 'update'])->name('matriks.update');
    Route::get('matriks/delete/{id}', [MatriksController::class, 'delete'])->name('matriks.delete');

    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    // Route::get('penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
    // Route::post('penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('penilaian/edit/{id}', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::post('penilaian/update', [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::get('penilaian/delete/{id}', [PenilaianController::class, 'delete'])->name('penilaian.delete');

    Route::get('dokumenInduk', [DokumenIndukController::class, 'index'])->name('dokumenInduk.index');
    // Route::get('dokumenInduk/create', [DokumenIndukController::class, 'create'])->name('dokumenInduk.create');
    // Route::post('dokumenInduk/store', [DokumenIndukController::class, 'store'])->name('dokumenInduk.store');
    Route::get('dokumenInduk/edit/{id}', [DokumenIndukController::class, 'edit'])->name('dokumenInduk.edit');
    Route::post('dokumenInduk/update', [DokumenIndukController::class, 'update'])->name('dokumenInduk.update');
    Route::get('dokumenInduk/delete/{id}', [DokumenIndukController::class, 'delete'])->name('dokumenInduk.delete');

    Route::get('account', [AccountController::class, 'index'])->name('account.index');
    Route::post('account/update', [AccountController::class, 'update'])->name('account.update');

});

//Route::get('tes', [TesController::class, 'tes']);
// Route::get('infoSinta/{author_id}', [TesController::class,'infoSinta']);
