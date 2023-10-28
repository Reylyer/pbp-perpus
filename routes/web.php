<?php

use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CrudBukuController;
use Illuminate\Support\Facades\Auth;
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
    // redirect to buku list
    Route::get('/', [BukuController::class, 'list'])->name('buku.list');
});

//  url/auth/register
// add guard middleware
Route::prefix('/auth')->group(function () {
    Route::get('/register', [AnggotaController::class, 'register'])->name('auth.register');
    Route::get('/login', [AnggotaController::class, 'login'])->name('auth.login');
    Route::post('/register', [AnggotaController::class, 'doRegister'])->name('auth.doRegister');
    Route::post('/login', [AnggotaController::class, 'doLogin'])->name('auth.doLogin');
    Route::get('/logout', [AnggotaController::class, 'doLogout'])->name('auth.doLogout');
});

// group route for kategori crud using controller
Route::prefix('kategori')->middleware(['petugas'])->group(function () {
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
    Route::post('/komentar/{idbuku}', [BukuController::class, 'komentar'])->name('buku.komentar');
    Route::post('/rating/{idbuku}', [BukuController::class, 'rating'])->name('buku.rating');
    Route::get('/{idbuku}', [BukuController::class, 'show'])->name('buku.show');
});

Route::prefix('crudbuku')->group(function () {
    Route::get('/', [CrudBukuController::class, 'list'])->name('crudbuku.list');
    Route::get('/create', [CrudBukuController::class, 'create'])->name('crudbuku.create');
    Route::post('/komentar/{idbuku}', [CrudBukuController::class, 'komentar'])->name('crudbuku.komentar');
    Route::post('/rating/{idbuku}', [CrudBukuController::class, 'rating'])->name('crudbuku.rating');
    Route::get('/{idbuku}', [CrudBukuController::class, 'show'])->name('crudbuku.show');
    Route::post('/do/create', [CrudBukuController::class, 'doCreate'])->name('crudbuku.doCreate');
    Route::get('/update/{idbuku}', [CrudBukuController::class, 'update'])->name('crudbuku.update');
    // dodelete and doupdate
    Route::put('/do/update/{idbuku}', [CrudBukuController::class, 'doUpdate'])->name('crudbuku.doUpdate');
    Route::delete('/do/delete/{idbuku}', [CrudBukuController::class, 'doDelete'])->name('crudbuku.doDelete');
    Route::post('/do/create', [CrudBukuController::class, 'doCreate'])->name('crudbuku.doCreate');
});


// url/anggota/verifikasi
Route::prefix('anggota')->group(function () {
    Route::get('/verifikasi', [AnggotaController::class, 'verifikasi'])->name('verifikasi.list');
    // verifikasi anggotan dengan id 1:
    // url/anggota/verifikasi/1
    Route::get('/verifikasi/{noktp}', [AnggotaController::class, 'doVerifikasi'])->name('verifikasi.doVerifikasi');
    Route::get('/riwayat', [AnggotaController::class, 'riwayat'])->name('anggota.riwayat');
});