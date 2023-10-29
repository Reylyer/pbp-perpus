<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Redirect;

class TransaksiController extends Controller
{

    function list(Request $request)
    {
        $auth = Auth::guard('anggota')->user();
        if (!$auth) {
            return redirect('/login');
        }
        $selesai = DB::select('SELECT
                                b.judul,
                                a.nama as peminjam,
                                p.tgl_pinjam,
                                dt.tgl_kembali,
                                dt.denda
                            FROM detail_transaksi dt
                            LEFT JOIN buku b ON dt.idbuku = b.idbuku
                            LEFT JOIN peminjaman p ON dt.idtransaksi = p.idtransaksi
                            LEFT JOIN anggota a ON p.noktp = a.noktp
                            where dt.tgl_kembali is not null and p.noktp = ?', [$auth->noktp]);

        $dipinjam = DB::select('SELECT
                                b.judul,
                                a.nama as peminjam,
                                p.tgl_pinjam,
                                dt.tgl_kembali,
                                dt.denda
                            FROM detail_transaksi dt
                            LEFT JOIN buku b ON dt.idbuku = b.idbuku
                            LEFT JOIN peminjaman p ON dt.idtransaksi = p.idtransaksi
                            LEFT JOIN anggota a ON p.noktp = a.noktp where p.noktp = ? and TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW()) < 14 and dt.tgl_kembali is null', [$auth->noktp]);

        $lewat = DB::select('SELECT
                                b.judul,
                                a.nama as peminjam,
                                p.tgl_pinjam,
                                dt.tgl_kembali,
                                CASE
                                WHEN TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW()) < 14 THEN 0
                                ELSE (TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW())-14) * 1000
                                END AS denda
                            FROM detail_transaksi dt
                            LEFT JOIN buku b ON dt.idbuku = b.idbuku
                            LEFT JOIN peminjaman p ON dt.idtransaksi = p.idtransaksi
                            LEFT JOIN anggota a ON p.noktp = a.noktp where p.noktp = ? and TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW()) > 14 and dt.tgl_kembali is null', [$auth->noktp]);

        return view('transaksi.list', ['selesai' => $selesai, 'dipinjam' => $dipinjam, 'lewat' => $lewat]);
    }

    function peminjaman(Request $request)
    {
        $peminjam = Anggota::All();
        $buku = Buku::All();
        return view(
            'transaksi.peminjaman',
            [
                'peminjam' => $peminjam,
                'buku' => $buku
            ]
        );
    }

    function pinjam(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();

        $request->validate([
            'noktp'       => 'required',
            'idbuku'      => 'required'
        ]);

        // $yang_di_pinjam = Peminjaman::join('noktp', '=', $request->noktp);
        $masih_dipinjam = Peminjaman::leftJoin(
            'detail_transaksi',
            'peminjaman.idtransaksi',
            '=',
            'detail_transaksi.idtransaksi'
        )
            ->where([
                ['detail_transaksi.tgl_kembali', '=', null],
                ['peminjaman.noktp', '=', $request->noktp]
            ])->get();

        $buku_in_question = Buku::find($request->idbuku);

        error_log($masih_dipinjam->count());
        if ($masih_dipinjam->count() >= 2) {
            error_log("2 peminjaman");
            $buku = Buku::whereIn('idbuku', $masih_dipinjam->pluck('idbuku')->toArray())->pluck('judul')->toArray();
            $yang_dipinjam = implode(' dan ', $buku);
            return Redirect::back()->withErrors(['msg' => "User ini sudah meminjam 2 yakni, $yang_dipinjam. Silahkan mengembalikan buku yang sudah dipinjam terlebih dahulu"]);
        } else if ($masih_dipinjam->count() == 1) {
            if ($masih_dipinjam->first()->idbuku == $buku_in_question->idbuku) {
                $judul = $buku_in_question->judul;
                return Redirect::back()->withErrors(['msg' => "User ini sudah meminjam $judul. Silahkan mengembalikan buku yang sudah dipinjam terlebih dahulu"]);
            }
        }

        error_log($buku_in_question->judul);

        if ($buku_in_question->stok_tersedia == 0) {
            $judul_buku = $buku_in_question->judul;
            return Redirect::back()->withErrors(['msg' => "$judul_buku kehabisan stok"]);
        }

        Buku::where("idbuku", $request->idbuku)
                 ->update(["stok_tersedia" => $buku_in_question->stok_tersedia - 1]);


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

        return redirect('/anggota/riwayat');
    }

    function pengembalian(Request $request)
    {
        $peminjaman = DB::select(
            "SELECT
                    dt.idtransaksi,
                    a.noktp,
                    a.nama as nama_peminjam,
                    b.judul,
                    b.isbn,
                    p.tgl_pinjam,
                    pt.nama as nama_petugas,
                CASE
                    WHEN NOW() < dt.tgl_kembali THEN 0
                    ELSE TIMESTAMPDIFF(DAY, p.tgl_pinjam, NOW()) * 1000
                END AS denda
                FROM detail_transaksi dt
                LEFT JOIN buku b ON dt.idbuku = b.idbuku
                LEFT JOIN peminjaman p ON dt.idtransaksi = p.idtransaksi
                LEFT JOIN anggota a ON p.noktp = a.noktp
                LEFT JOIN petugas pt ON p.idpetugas = pt.idpetugas
                WHERE
                    dt.tgl_kembali IS NULL
                "
        );

        return view(
            'transaksi.pengembalian',
            ['peminjaman' => $peminjaman]
        );
    }

    function mengembalikan(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();
        Transaksi::where("idtransaksi", $request->idtransaksi)
                 ->update(["denda" => $request->denda,
                           "tgl_kembali" => now(),
                           "idpetugas" => $petugas->idpetugas]);

        $idbuku = Transaksi::where("idtransaksi", $request->idtransaksi)->first()->idbuku;
        $buku_in_question = Buku::find($idbuku);
        Buku::where("idbuku", $idbuku)
            ->update(["stok_tersedia" => $buku_in_question->stok_tersedia + 1]);
        return redirect('/transaksi/pengembalian');
    }
}
