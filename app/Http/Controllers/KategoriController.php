<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    
    function list(Request $request){

        $data = Kategori::all();
        return view('kategori.list', ['data' => $data]);
    }
    
    function show($idkategori){
        $data = Kategori::where('idkategori', $idkategori)->first();
        return view('kategori.show', ['data' => $data]);
    }
    
    function update($idkategori){
        $data = Kategori::where('idkategori', $idkategori)->first();
        return view('kategori.update', ['data' => $data]);

    }
    
    function doUpdate(Request $request, $idkategori){
        if(null !== $request->input('nama'))
            $nama = $request->input('nama');

        $query = DB::update('update kategori set nama = ? where idkategori = ?', [$nama, $idkategori]);
        return redirect()->route('kategori.list');
    }
    
    function create(){
        return view('kategori.create');
    }
    
    function doCreate(Request $request){
        if(null !== $request->input('nama'))
            $nama = $request->input('nama');
        
        $create = DB::insert('insert into kategori (nama) values (?)', [$nama]);
        return redirect()->route('kategori.list');

    }
    
    function doDelete(Request $request, $idkategori){
        $delete = DB::delete('delete from kategori where idkategori = ?', [$idkategori]);
        return redirect()->route('kategori.list');
    }
}
