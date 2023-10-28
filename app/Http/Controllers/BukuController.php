<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\KomentarBuku;
use App\Models\RatingBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    function list(Request $request)
    {
        $books = DB::select(
            "SELECT
                b.idbuku as idbuku,
                b.isbn as isbn,
                b.judul as judul,
                k.nama as nama_kategori,
                b.pengarang as pengarang,
                b.penerbit as penerbit,
                b.tahun_terbit as tahun
            FROM buku b
            JOIN kategori k
            ON b.idkategori = k.idkategori
            WHERE isbn LIKE '%$request->s%'
            OR b.judul LIKE '%$request->s%'
            OR k.nama LIKE '%$request->s%'
            OR b.pengarang LIKE '%$request->s%'
            OR b.penerbit LIKE '%$request->s%'
            OR b.tahun_terbit LIKE '%$request->s%'
            ",
        );


        return view('buku.list', ['books' => $books]);
    }

    function show($idbuku)
    {
        $book = DB::select(
            "SELECT b.idbuku as idbuku,
                    b.isbn as isbn,
                    b.judul as judul,
                    k.nama as kategori,
                    b.pengarang as pengarang,
                    b.penerbit as penerbit,
                    b.kota_terbit as kota_terbit,
                    b.editor as editor,
                    b.file_gambar as file_gambar,
                    b.stok as stok,
                    b.stok_tersedia as stok_tersedia,
                    b.tahun_terbit as tahun
            FROM buku b
            JOIN kategori k
            ON b.idkategori = k.idkategori
            WHERE b.idbuku = ?",
            [$idbuku]
        );

        $komentar = KomentarBuku::join('anggota', 'anggota.noktp', '=', 'komentar_buku.noktp')
                                  ->where('idbuku', '=', "$idbuku")
                                  ->get();

        $rating = DB::select("SELECT AVG(skor_rating) as rating
                              FROM rating_buku
                              WHERE idbuku = '$idbuku'
                              ");

        $rating = $rating ? number_format($rating[0]->rating, 1) : null;

        return view('buku.show', ['book' => $book[0], 'komentar' => $komentar, 'rating' => $rating]);
    }

    function search(Request $request)
    {
        return Buku::search($request->s)->get();
    }

    function komentar(Request $request, $idbuku){
        $anggota = Auth::guard('anggota')->user();

        if ($request->input('komentar') !== null) {
            $komentar = KomentarBuku::create([
                'idbuku'   => $idbuku,
                'noktp'    => $anggota->noktp,
                'komentar' => $request->input('komentar')
            ]);
            $komentar->save();
        }

        return redirect("/buku/$idbuku");
    }

    function rating(Request $request, $idbuku){
        $anggota = Auth::guard('anggota')->user();

        $isAlreadyRated = DB::select("SELECT * FROM rating_buku WHERE idbuku = '$idbuku' AND noktp = '$anggota->noktp'");

        if ($isAlreadyRated) {
            return Redirect::back()->withErrors(['msg' => 'Anda sudah memberikan rating']);
        }

        if ($request->input('rating') !== null && !$isAlreadyRated) {
            $rating = RatingBuku::create([
                'idbuku'      => $idbuku,
                'noktp'       => $anggota->noktp,
                'skor_rating' => $request->input('rating')
            ]);
            $rating->save();
        }

        return redirect("/buku/$idbuku");
    }
}
