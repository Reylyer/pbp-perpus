<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    function list(Request $request)
    {
        $books = Buku::search($request->s)->get();

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

    function search(Request $request)
    {
        return Buku::search($request->s)->get();
    }

    function create(){
        $kategori_pair = Kategori::all('idkategori', 'nama');
        return view('buku.create', ['kategori_pair' => $kategori_pair]);
    }

    function doCreate(Request $request){
        $validated = $request->validate([
            'isbn'        => 'required|string|unique:buku',
            'judul'       => 'required|string',
            'idkategori'  => 'required',
            'pengarang'   => 'required|string',
            'penerbit'    => 'required|string',
            'kota_terbit' => 'required|string',
            'editor'      => 'required|string',
            'file_gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stok'        => 'nullable|numeric',
        ]);

        if ($validated['file_gambar'] !== null) {
            $imageName = time().'.'.$validated['file_gambar']->extension();
            $validated['file_gambar']->storeAs('images', $imageName);
            $validated['file_gambar'] = $imageName;
        }

        $validated['stok_tersedia'] = $validated['stok'];

        $buku = Buku::create($validated);
        error_log($buku);
        $buku->save();

        // $create = DB::insert('insert into buku (isbn, judul, idkategori, pengarang, kota_terbit, editor, file_gambar, stok) values (?)',
        //                     [$isbn, $judul, $idkategori, $pengarang, $penerbit, $editor, $file_gambar]);

        return redirect()->route('buku.list');

    }
}
