<?php

//use Architecture\External\Select2\Controller\Select2AkurasiPenelitianController;

use Architecture\External\Select2\Controller\Select2MatriksController;
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
Route::get('/matriks', [Select2MatriksController::class,'List'])->name('select2.Matriks.List');