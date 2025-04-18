<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriUkmController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\UserController;

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

//Route::get('/', function () {
  //  return view('welcome');});
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); // Halaman awal level
    Route::post('/list', [LevelController::class, 'list']); // DataTables JSON
    Route::get('/create', [LevelController::class, 'create']); // Form tambah level
    Route::post('/', [LevelController::class, 'store']); // Simpan level baru
    Route::get('/{id}', [LevelController::class, 'show']); // Detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // Form edit level
    Route::put('/{id}', [LevelController::class, 'update']); // Update level
    Route::delete('/{id}', [LevelController::class, 'destroy']); // Hapus level
  });

  Route::group(['prefix' => 'kategori_ukm'], function () {
    Route::get('/', [KategoriUkmController::class, 'index']);      // Halaman awal kategori
    Route::post('/list', [KategoriUkmController::class, 'list']);      // DataTables JSON
    Route::get('/create', [KategoriUkmController::class, 'create']);  // Form tambah kategori
    Route::post('/', [KategoriUkmController::class, 'store']);         // Simpan kategori baru
    Route::get('/{id}', [KategoriUkmController::class, 'show']);         // Detail kategori
    Route::get('/{id}/edit', [KategoriUkmController::class, 'edit']);   // Form edit kategori
    Route::put('/{id}', [KategoriUkmController::class, 'update']);      // Update kategori
    Route::delete('/{id}', [KategoriUkmController::class, 'destroy']);  // Hapus kategori
});

Route::group(['prefix' => 'ukm'], function () {
  Route::get('/', [UkmController::class, 'index']);       // Halaman awal UKM
  Route::post('/list', [UkmController::class, 'list']);   // DataTables JSON
  Route::get('/create', [UkmController::class, 'create']); // Form tambah UKM
  Route::post('/', [UkmController::class, 'store']);      // Simpan UKM baru
  Route::get('/{id}', [UkmController::class, 'show']);    // Detail UKM
  Route::get('/{id}/edit', [UkmController::class, 'edit']); // Form edit UKM
  Route::put('/{id}', [UkmController::class, 'update']);  // Update UKM
  Route::delete('/{id}', [UkmController::class, 'destroy']); // Hapus UKM
});

Route::group(['prefix' => 'user'], function () {
  Route::get('/', [UserController::class, 'index']);         // Halaman awal user
  Route::post('/list', [UserController::class, 'list']);     // DataTables JSON
  Route::get('/create', [UserController::class, 'create']);  // Form tambah user
  Route::post('/', [UserController::class, 'store']);        // Simpan user baru
  Route::get('/{id}', [UserController::class, 'show']);      // Detail user
  Route::get('/{id}/edit', [UserController::class, 'edit']); // Form edit user
  Route::put('/{id}', [UserController::class, 'update']);    // Update user
  Route::delete('/{id}', [UserController::class, 'destroy']); // Hapus user
});
