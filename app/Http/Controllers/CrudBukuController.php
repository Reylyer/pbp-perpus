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

class CrudBukuController extends Controller
{
    function list(Request $request)
    {
        $books = DB::select(
            "SELECT b.idbuku as idbuku, b.isbn as isbn, b.judul as judul, k.nama as nama_kategori, b.pengarang as pengarang, b.penerbit as penerbit, YEAR(b.tgl_insert) as tahun
            FROM buku b JOIN kategori k ON b.idkategori = k.idkategori
            WHERE isbn LIKE '%$request->s%'
            OR b.isbn LIKE '%$request->s%'
            OR k.nama LIKE '%$request->s%'
            OR b.pengarang LIKE '%$request->s%'
            OR b.penerbit LIKE '%$request->s%'
            ",
        );


        return view('crudbuku.list', ['books' => $books]);
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
                    YEAR(b.tgl_insert) as tahun
            FROM buku b JOIN kategori k ON b.idkategori = k.idkategori
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

        return view('crudbuku.show', ['book' => $book[0], 'komentar' => $komentar, 'rating' => $rating]);
    }

    function search(Request $request)
    {
        return Buku::search($request->s)->get();
    }

    function create(){
        $kategori_pair = Kategori::all('idkategori', 'nama');
        return view('crudbuku.create', ['kategori_pair' => $kategori_pair]);
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
            $save_path = Storage::disk('local')->put('public/images', $validated['file_gambar']);
            $parts = explode('/', $save_path);
            $validated['file_gambar'] = end($parts);
            error_log($validated['file_gambar']);
        }

        $validated['stok_tersedia'] = $validated['stok'];

        $buku = Buku::create($validated);
        error_log($buku);
        $buku->save();

        // $create = DB::insert('insert into buku (isbn, judul, idkategori, pengarang, kota_terbit, editor, file_gambar, stok) values (?)',
        //                     [$isbn, $judul, $idkategori, $pengarang, $penerbit, $editor, $file_gambar]);

        return redirect()->route('crudbuku.list');

    }

    function komentar(Request $request, $idbuku){
        $anggota = $request->session()->get('anggota');

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
        $anggota = $request->session()->get('anggota');

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

    function update($idbuku){
        $data = Buku::where('idbuku', $idbuku)->first();
        $kategori_pair = Kategori::all('idkategori', 'nama');
        return view('crudbuku.update', ['data' => $data, 'kategori_pair' => $kategori_pair]);

    }
    
    function doUpdate(Request $request, $idbuku){
        if(null !== $request->input('isbn'))
            $isbn = $request->input('isbn');
        if(null !== $request->input('judul'))
            $judul = $request->input('judul');
        if(null !== $request->input('idkategori'))
            $idkategori = $request->input('idkategori');
        if(null !== $request->input('pengarang'))
            $pengarang = $request->input('pengarang');
        if(null !== $request->input('penerbit'))
            $penerbit = $request->input('penerbit');
        if(null !== $request->input('kota_terbit'))
            $kota_terbit = $request->input('kota_terbit');
        if(null !== $request->input('editor'))
            $editor = $request->input('editor');
        if(null !== $request->input('file_gambar'))
            $file_gambar = $request->input('file_gambar');
        if(null !== $request->input('stok'))
            $stok = $request->input('stok');
        if(null !== $request->input('stok_tersedia'))
            $stok_tersedia = $request->input('stok_tersedia');
        if(null !== $request->input('tahun_terbit'))
            $tahun_terbit = $request->input('tahun_terbit');
        $tgl_insert = date('Y-m-d H:i:s');

        
        
        // buku (isbn, judul, pengarang, penerbit, kota_terbit, editor, file_gambar, stok, stok_tersedia, idkategori, tahun_terbit, tgl_insert, tgl_update)
        $update = DB::update('update buku set isbn = ?,
            judul = ?,
            idkategori = ?,
            pengarang = ?,
            penerbit = ?,
            kota_terbit = ?,
            editor = ?,
            stok = ?,
            stok_tersedia = ?,
            tahun_terbit = ?,
            tgl_insert = ? where idbuku = ?', [$isbn, $judul, $idkategori, $pengarang, $penerbit, $kota_terbit, $editor, $stok, $stok_tersedia, $tahun_terbit, $tgl_insert, $idbuku]);
        return redirect()->route('crudbuku.list');
    }

    function doDelete(Request $request, $idbuku){
        $delete = DB::delete('delete from buku where idbuku = ?', [$idbuku]);
        return redirect()->route('crudbuku.list');
    }
}
