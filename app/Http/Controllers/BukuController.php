<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    function list(Request $request)
    {
        $books = DB::select(
            "SELECT b.isbn as isbn, b.judul as judul, k.nama as kategori, b.pengarang as pengarang, b.penerbit as penerbit, YEAR(b.tgl_insert) as tahun
            FROM buku b JOIN kategori k ON b.idkategori = k.idkategori"
        );

        return view('buku.list', ['books' => $books]);
    }

    function show($isbn)
    {
        $book = DB::select(
            "SELECT b.isbn as isbn, b.judul as judul, k.nama as kategori, b.pengarang as pengarang, b.penerbit as penerbit, b.kota_terbit as kota_terbit, b.editor as editor, b.file_gambar as file_gambar, b.stok as stok, b.stok_tersedia as stok_tersedia, YEAR(b.tgl_insert) as tahun
            FROM buku b JOIN kategori k ON b.idkategori = k.idkategori
            WHERE b.isbn = ?",
            [$isbn]
        );

        return view('buku.show', ['book' => $book[0]]);
    }
}
