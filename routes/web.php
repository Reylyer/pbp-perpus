<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Http\Controllers\KategoriController;

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
    return redirect()->route('kategori.list');
});

// group route for kategori crud using controller
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/{id}', [KategoriController::class, 'list'])->name('kategori.show');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}/delete', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    // dodelete and doupdate
    Route::put('/do/update/{id}', [KtegoriController::class, 'doUpdate'])->name('kategori.doUpdate');
    Route::put('/do/delete/{id}', [KtegoriController::class, 'doDelete'])->name('kategori.doDelete');
});

