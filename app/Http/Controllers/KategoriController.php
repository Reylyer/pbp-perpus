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
    
    function show($id){
        $data = Kategori::where('idkategori', $id)->first();
        return view('kategori.show', ['data' => $data]);
    }
    
    function update($id){
        $book = DB::select('select b.*, c.name as category  from books b LEFT JOIN categories c ON b.category_id = c.id WHERE b.id = ?', [$id]);
        $categories = DB::select('select * from categories');
        return view('update.books', ['book' => $book[0], 'categories' => $categories]);
    }
    
    function doUpdate(Request $request, $id){
        if(null !== $request->input('title'))
            $title = $request->input('title');
        if(null !== $request->input('author'))
            $author = $request->input('author');
        if(null !== $request->input('category_id'))
            $category_id = $request->input('category_id');
        if(null !== $request->input('price'))
            $price = $request->input('price');
        if(null !== $request->input('stock'))
            $stock = $request->input('stock');

        $query = DB::update('update books set title = ?, author = ?, category_id = ?, price = ?, stock = ? where id = ?', [$title, $author, $category_id, $price, $stock, $id]);
        return redirect()->route('books.list');
    }
    
    function create(){
        $categories = DB::select('select * from categories');
        return view('create.books', ['categories' => $categories]);
    }
    
    function doCreate(Request $request){
        if(null !== $request->input('title'))
            $title = $request->input('title');
        if(null !== $request->input('author'))
            $author = $request->input('author');
        if(null !== $request->input('category_id'))
            $category_id = $request->input('category_id');
        if(null !== $request->input('price'))
            $price = $request->input('price');
        if(null !== $request->input('stock'))
            $stock = $request->input('stock');
        if(null !== $request->input('isbn'))
            $isbn = $request->input('isbn');
        
        $create = DB::insert('insert into books (isbn, title, author, category_id, price, stock) values (?, ?, ?, ?, ?, ?)', [$isbn, $title, $author, $category_id, $price, $stock]);
        return redirect()->route('books.list');

    }
    
    function doDelete(Request $request, $id){
        $delete = DB::delete('delete from books where id = ?', [$id]);
        return redirect()->route('books.list');
    }
}
