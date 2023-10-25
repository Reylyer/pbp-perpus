<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;

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

Route::get('/', function () {
    // redirect to kategori list
    return redirect()->route('buku.list');
});

// group route for kategori crud using controller
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/show/{idkategori}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/edit/{idkategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::get('/update/{idkategori}', [KategoriController::class, 'update'])->name('kategori.update');
    // dodelete and doupdate
    Route::put('/do/update/{idkategori}', [KategoriController::class, 'doUpdate'])->name('kategori.doUpdate');
    Route::delete('/do/delete/{idkategori}', [KategoriController::class, 'doDelete'])->name('kategori.doDelete');
    Route::post('/do/create', [KategoriController::class, 'doCreate'])->name('kategori.doCreate');
});

Route::prefix('buku')->group(function () {
    Route::get('/', [BukuController::class, 'list'])->name('buku.list');
    Route::get('/create', [BukuController::class, 'create'])->name('buku.create');
    Route::get('/{isbn}', [BukuController::class, 'show'])->name('buku.show');
    Route::post('/do/create', [BukuController::class, 'doCreate'])->name('buku.doCreate');
});