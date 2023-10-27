<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator,Redirect,Response,Storage;


class AnggotaController extends Controller {
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
