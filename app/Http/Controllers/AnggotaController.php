<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class AnggotaController extends Controller {

    function verifikasi(){
        $anggota = DB::select("SELECT * FROM anggota WHERE status = 0");
        // dd($anggota);
        return view('anggota.verifikasi', ['data' => $anggota]);
    }

    function riwayat(){
        // TODO: data yang harus disiapkan:
        // -	Peminjaman buku yang sudah selesai atau sdh dikembalikan
        // -	Peminjaman buku yang sedang berlangsung
        // -	Peminjaman buku yang belum dikembalikan dan telah melebihi tanggal Kembali beserta jumlah denda yang harus dibayarkan.
        
        // SELECT all in detail_transaksi if tgl_kembali not null
        $peminjaman1 = DB::select("SELECT * FROM detail_transaksi LEFT JOIN buku ON detail_transaksi.idbuku = buku.idbuku LEFT JOIN petugas ON detail_transaksi.idpetugas = petugas.idpetugas WHERE tgl_kembali IS NOT NULL");

        dd($peminjaman1);

    }

    function doVerifikasi($noktp){
        $anggota = DB::select("SELECT * FROM anggota WHERE noktp = ?", [$noktp]);
        if($anggota){
            $query = DB::update("UPDATE anggota SET status = 1 WHERE noktp = ?", [$noktp]);
            return redirect()->route('verifikasi.list');
        } else {
            return redirect()->route('verifikasi.list');
        }
    }
    // url/auth/register
    function register() {
        return view('register');
    }
    function login() {
        return view('login');
    }

    function doRegister(Request $request) {
        $validated = $request->validate([
            'noktp'       => 'required|string|unique:anggota',
            'nama'        => 'required|string',
            'password'    => 'required|string',
            'alamat'      => 'required|string',
            'kota'        => 'required|string',
            'email'       => 'required|string|unique:anggota',
            'no_telp'     => 'required|string',
            'file_ktp'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['file_ktp'] = Storage::disk('public')->put('images', $validated['file_ktp']);
        $anggota = Anggota::create($validated);
        error_log($anggota);
        $anggota->save();

        return redirect()->route('auth.login');
    }

    function doLogin(Request $request) {
        $anggota = Anggota::where('email', $request->email)->first();
        if ($anggota && $anggota->password == $request->password) {
            if ($anggota->status == 0) {
                return Redirect::back()->withErrors(['msg' => 'Akun anda belum diaktifkan']);
            }
            Session::put('anggota', $anggota);
            return redirect()->route('buku.list');
        }
        return Redirect::back()->withErrors(['msg' => 'Salah kredensial']);
    }
}
