<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Auth;

class PeminjamanController extends Controller
{
    function pinjam(Request $request) {
        $petugas = Auth::guard('petugas')->user();

        $validated = $request->validate([
            'noktp'       => 'required',
            'idbuku'      => 'required'
        ]);

        $validated['idpetugas'] = $petugas->idpetugas;

        $peminjaman = Peminjaman::create($validated);

        $data_transaksi = [
            'idtransaksi' => $peminjaman->idtransaksi,
            'idbuku'      => $validated['idbuku'],
        ];

        $transaksi = Transaksi::create($data_transaksi);

        $peminjaman->save();
        $transaksi->save();
    }


}
