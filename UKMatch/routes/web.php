<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;

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
  
  Route::get('/cek-view', function () {
    return view('level.index');
});
