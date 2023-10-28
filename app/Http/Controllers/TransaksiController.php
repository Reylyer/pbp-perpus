<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

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

    // function show($idkategori)
    // {
    //     $data = Kategori::where('idkategori', $idkategori)->first();
    //     return view('kategori.show', ['data' => $data]);
    // }

    // function update($idkategori)
    // {
    //     $data = Kategori::where('idkategori', $idkategori)->first();
    //     return view('kategori.update', ['data' => $data]);
    // }

    // function doUpdate(Request $request, $idkategori)
    // {
    //     if (null !== $request->input('nama'))
    //         $nama = $request->input('nama');

    //     $query = DB::update('update kategori set nama = ? where idkategori = ?', [$nama, $idkategori]);
    //     return redirect()->route('kategori.list');
    // }

    // function create()
    // {
    //     return view('kategori.create');
    // }

    // function doCreate(Request $request)
    // {
    //     if (null !== $request->input('nama'))
    //         $nama = $request->input('nama');

    //     $create = DB::insert('insert into kategori (nama) values (?)', [$nama]);
    //     return redirect()->route('kategori.list');
    // }

    // function doDelete(Request $request, $idkategori)
    // {
    //     $delete = DB::delete('delete from kategori where idkategori = ?', [$idkategori]);
    //     return redirect()->route('kategori.list');
    // }
}
