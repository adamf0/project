<?php

//use Architecture\External\Api\Controller\ApiAdministrasiAreaController;

use Architecture\External\Api\Controller\ApiDokumenIndukController;
use Architecture\External\Api\Controller\ApiPenilaianController;
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
Route::post('/penilaian', [ApiPenilaianController::class,'create'])->name('api.Penilaian.create');
Route::post('/dokumen_induk', [ApiDokumenIndukController::class,'create'])->name('api.DokumenInduk.create');