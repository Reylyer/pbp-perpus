<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Auth, Redirect;

class TransaksiController extends Controller
{

    function list(Request $request)
    {
        $data = DB::select('SELECT
                                b.judul,
                                a.nama as peminjam,
                                p.tgl_pinjam,
                                dt.tgl_kembali,
                                CASE
                                    WHEN NOW() < dt.tgl_kembali THEN 0
                                    ELSE TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW()) * 1000
                                END AS denda
                            FROM detail_transaksi dt
                            LEFT JOIN buku b ON dt.idbuku = b.idbuku
                            LEFT JOIN peminjaman p ON dt.idtransaksi = p.idtransaksi
                            LEFT JOIN anggota a ON p.noktp = a.noktp');

        return view('transaksi.list', ['data' => $data]);
    }

    function peminjaman(Request $request) {
        $peminjam = Anggota::All();
        $buku = Buku::All();
        return view('transaksi.peminjaman',
                     ['peminjam' => $peminjam,
                      'buku' => $buku]);
    }

    function pinjam(Request $request) {
        $petugas = Auth::guard('petugas')->user();

        $validated = $request->validate([
            'noktp'       => 'required',
            'idbuku'      => 'required'
        ]);

        // $yang_di_pinjam = Peminjaman::join('noktp', '=', $request->noktp);
        $masih_dipinjam = Peminjaman::leftJoin('detail_transaksi', 'peminjaman.idtransaksi',
                                                              '=', 'detail_transaksi.idtransaksi')
                                    ->where([
                                        ['detail_transaksi.tgl_kembali', '!=', null],
                                        ['peminjaman.noktp', '=', $request->noktp]
                                    ])->get();

        $buku_in_question = Buku::find($request->idbuku);

        if ($masih_dipinjam->count() >= 2) {
            error_log("2 peminjaman");

            // $yang_dipinjam = implode(' dan ', $buku_in_question->judul);
            return Redirect::back()->withErrors(['msg' => "User ini sudah meminjam 2. Silahkan mengembalikan buku yang sudah dipinjam terlebih dahulu"]);
        }

        error_log($buku_in_question->judul);

        if ($buku_in_question->stok_tersedia == 0) {
            $judul_buku = $buku_in_question->judul;
            return Redirect::back()->withErrors(['msg' => "$judul_buku kehabisan stok"]);
        }


        $peminjaman = Peminjaman::create([
                'noktp' => $request->noktp,
                'idpetugas' => $petugas->idpetugas
        ]);

        $transaksi = Transaksi::create([
                'idtransaksi' => $peminjaman->idtransaksi,
                'idbuku'      => $request->idbuku
        ]);

        $peminjaman->save();
        $transaksi->save();

        return redirect('/transaksi/peminjaman');
    }
}
