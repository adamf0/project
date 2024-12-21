<?php

// use Architecture\External\Datatable\Controller\DatatableAkurasiPenelitianController;

use Architecture\External\Datatable\Controller\DatatableDokumenIndukController;
use Architecture\External\Datatable\Controller\DatatableMatriksController;
use Architecture\External\Datatable\Controller\DatatablePenilaianController;
use Architecture\External\Datatable\Controller\DatatableUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('matriks', [DatatableMatriksController::class,'index'])->name('datatable.Matriks.index');
Route::get('penilaian', [DatatablePenilaianController::class,'index'])->name('datatable.Penilaian.index');
Route::get('dokumen_induk', [DatatableDokumenIndukController::class,'index'])->name('datatable.DokumenInduk.index');
Route::get('user', [DatatableUserController::class,'index'])->name('datatable.User.index');