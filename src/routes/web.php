<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResepController;

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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('userdata', UserDataController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'userdata.index',
        'create' => 'userdata.create',
        'store' => 'userdata.store',
        'show' => 'userdata.show',
        'edit' => 'userdata.edit',
        'update' => 'userdata.update',
        'destroy' => 'userdata.destroy',
    ]);

Route::resource('pemeriksaan', PemeriksaanController::class)
    ->middleware(['auth', 'role:admin,dokter'])
    ->names([
        'index' => 'pemeriksaan.index',
        'create' => 'pemeriksaan.create',
        'store' => 'pemeriksaan.store',
        'show' => 'pemeriksaan.show',
        'edit' => 'pemeriksaan.edit',
        'update' => 'pemeriksaan.update',
        'destroy' => 'pemeriksaan.destroy',
    ]);    

Route::prefix('resep')->group(function () {
    Route::get('/', [ResepController::class, 'index'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.index');
    Route::get('/{pemeriksaan}', [ResepController::class, 'create'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.create');
    Route::post('/store', [ResepController::class, 'store'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.store');
    Route::get('/show/{pemeriksaan}', [ResepController::class, 'show'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.show');
    Route::put('/{resep}', [ResepController::class, 'update'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.update');
    Route::delete('/{resep}', [ResepController::class, 'delete'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.delete');   
});

// routes/web.php
Route::get('/resep/export-pdf/{pemeriksaan}', [ResepController::class, 'exportPdf'])->middleware(['auth', 'role:admin,dokter,apoteker'])->name('resep.export-pdf');
