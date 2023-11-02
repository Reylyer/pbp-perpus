<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AnggotaController extends Controller
{

    function verifikasi()
    {
        $anggota = DB::select("SELECT * FROM anggota WHERE status = 0");
        // dd($anggota);
        return view('anggota.verifikasi', ['data' => $anggota]);
    }

    function riwayat()
    {
        // SELECT semua jenis peminjaman
        $peminjamanSelesai = DB::select("SELECT * FROM detail_transaksi LEFT JOIN petugas ON detail_transaksi.idpetugas = petugas.idpetugas LEFT JOIN buku ON detail_transaksi.idbuku = buku.idbuku WHERE tgl_kembali IS NOT NULL");

        $peminjamanBerlangsung = DB::select("SELECT * FROM detail_transaksi LEFT JOIN petugas ON detail_transaksi.idpetugas = petugas.idpetugas LEFT JOIN buku ON detail_transaksi.idbuku = buku.idbuku WHERE tgl_kembali IS NULL");

        // SELECT peminjaman yang belum dikembalikan dan melebihi tanggal kembali
        // $peminjamanTerlambat = DB::select("SELECT * FROM detail_transaksi LEFT JOIN petugas ON detail_transaksi.idpetugas = petugas.idpetugas LEFT JOIN buku ON detail_transaksi.idbuku = buku.idbuku WHERE tgl_kembali IS NULL AND CURDATE() > tgl_kembali");

        // select from peminjaman where current date is more than tgl_pinjam + 7 days
        // add day_late column to calculate denda based on how many days is late
        // calculate denda for every day is late, + 1000
        $peminjamanTerlambat = DB::select("SELECT *, DATEDIFF(CURDATE(), tgl_pinjam) AS day_late, CASE
        WHEN TIMESTAMPDIFF(DAY, tgl_pinjam, NOW()) < 14 THEN 0
        ELSE (TIMESTAMPDIFF(DAY, tgl_pinjam, NOW())-14) * 1000
        END AS denda FROM peminjaman LEFT JOIN anggota ON anggota.noktp=peminjaman.noktp WHERE CURDATE() > DATE_ADD(tgl_pinjam, INTERVAL 7 DAY)");



        return view('anggota.riwayat', [
            'peminjamanSelesai' => $peminjamanSelesai,
            'peminjamanBerlangsung' => $peminjamanBerlangsung,
            'peminjamanTerlambat' => $peminjamanTerlambat,
        ]);
    }


    function doVerifikasi($noktp)
    {
        $anggota = DB::select("SELECT * FROM anggota WHERE noktp = ?", [$noktp]);
        if ($anggota) {
            $query = DB::update("UPDATE anggota SET status = 1 WHERE noktp = ?", [$noktp]);
            return redirect()->route('verifikasi.list');
        } else {
            return redirect()->route('verifikasi.list');
        }
    }
    // url/auth/register
    function register()
    {
        return view('register');
    }
    function login()
    {
        return view('login');
    }

    function doRegister(Request $request)
    {
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

        if ($validated['file_ktp'] !== null) {
            $save_path = Storage::disk('local')->put('public/images', $validated['file_ktp']);
            $parts = explode('/', $save_path);
            $validated['file_ktp'] = end($parts);
            error_log($validated['file_ktp']);
        }
        $validated['password'] = bcrypt($validated['password']);

        $anggota = Anggota::create($validated);
        error_log($anggota);
        $anggota->save();

        return redirect()->route('auth.login');
    }

    function doLogin(Request $request)
    {
        $user = Anggota::where('email', $request->email)->first();
        $user_type = 'anggota';
        if ($user) {
            if ($user->status == 0) {
                return Redirect::back()->withErrors(['msg' => 'Akun anda belum diaktifkan']);
            }
        } else if (!$user) {
            $user_type = 'petugas';
            $user = Petugas::where('email', $request->email)->first();
            if (!$user) {
                return Redirect::back()->withErrors(['msg' => 'Akun tidak ditemukan']);
            }
        }

        $credentials = $request->only('email', 'password');
        if ($user_type == 'petugas') {
            if (Hash::check($request->password, $user->password)) {
                Auth::guard('petugas')->login($user);
                return redirect()->route('crudbuku.list');
            }
        } else {
            if (Hash::check($request->password, $user->password)) {
                Auth::guard('anggota')->login($user);
                return redirect()->route('buku.list');
            }
        }
        return Redirect::back()->withErrors(['msg' => 'Salah kredensial']);
    }

    function doLogout(Request $request)
    {
        Auth::guard('anggota')->logout();
        Auth::guard('petugas')->logout();
        return redirect()->route('auth.login');
    }
}
