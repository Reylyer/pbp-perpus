<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriControllerOld extends Controller
{
    protected    $relations = Kategori::FIELD_RELATIONS;
    protected    $tableName = Kategori::TABLE;
    protected    $searchable = Kategori::FIELD_SEARCHABLE;
    protected    $sortable = Kategori::FIELD_SORTABLE;
    protected    $alias = Kategori::FIELD_ALIAS;
    protected    $fields = Kategori::FIELDS;
    protected    $fieldTypes = Kategori::FIELD_TYPES;
    protected    $id = Kategori::ID;
    protected    $title = Kategori::TITLE;
    
    function list(Request $request){

        $relations = Kategori::FIELD_RELATIONS;
        $tableName = Kategori::TABLE;
        $searchable = Kategori::FIELD_SEARCHABLE;
        $sortable = Kategori::FIELD_SORTABLE;
        $alias = Kategori::FIELD_ALIAS;
        $fields = Kategori::FIELDS;
        $fieldTypes = Kategori::FIELD_TYPES;
        $id = Kategori::ID;
        $title = Kategori::TITLE;


        $relationJoin = "";
        $relationQuery = "";
        foreach($relations as $key => $value) {
            $linkTable = $value['linkTable'];
            $aliasTable = $value['aliasTable'];
            $linkField = $value['linkField'];
            $displayName = $value['displayName'];
            $selectFields = $value['selectFields'];
            $selectValue = $value['selectValue'];
            $selectFields = implode(", ", $selectFields);
            $relationJoin .= " LEFT JOIN $linkTable $aliasTable ON {$tableName}.$key = $aliasTable.$linkField";
            foreach($value['selectFields'] as $selectField) {
            $relationQuery .= ", $aliasTable.$selectField AS $selectValue";
            }
        }

        $finalQuery = "SELECT {$tableName}.* $relationQuery FROM {$tableName}  $relationJoin  ";


        $totalCount = DB::selectOne("SELECT COUNT(*) as count FROM {$tableName}")->count;
        function toggleOrder($currentDirection) {
            return ($currentDirection == 'asc') ? 'desc' : 'asc';
        }
        // 

        if (null !== ($request->input('search'))) {
            $searchTerm = $request->input('search');
            $queryFilter = " TRUE OR ";
            $searchableList = [];
            foreach ($searchable as $key => $value) {
                $searchableList[] = " UPPER($value) LIKE '%{$searchTerm}%' ";
            }
            $finalQuery = $finalQuery ." WHERE TRUE " . " AND (" . implode(" OR ", $searchableList) . ") ";
        } 
        if(null !== ($request->input('orderBy'))) {
            $orderBy = $request->input('orderBy');
            $isRelation = false;
            $queryOrderBy = $orderBy;
            foreach($relations as $key => $value) {
                if($key == $orderBy) {
                    $isRelation = true;
                    break;
                }
            }
            if($isRelation) {
                $queryOrderBy = $value['aliasTable'] . "." . $value['linkField'];
            }
            $order = $request->input('order');
            $finalQuery = $finalQuery . " ORDER BY $queryOrderBy $order";
        }
        $page = null !== ($request->input('page')) ? intval($request->input('page')) : 1;
        $limit = null !== ($request->input('limit')) ? intval($request->input('limit')) : 10;
        $offset = ($page - 1) * $limit;
        $finalQuery = $finalQuery . " LIMIT $limit OFFSET $offset";
        $res = DB::select($finalQuery);

        // $books = DB::select('select b.*, c.name as category from books b LEFT JOIN categories c ON b.category_id = c.id');
        // return view('list.books', ['books' => $books]);
        $data = [$res, $totalCount, $limit, $page, $searchTerm ?? '', $orderBy ?? '', $order ?? ''];
        $data = [
            'res' => $res,
            'totalCount' => $totalCount,
            'limit' => $limit,
            'page' => $page,
            'searchTerm' => $searchTerm ?? '',
            'orderBy' => $orderBy ?? '',
            'order' => $order ?? '',

        ];
        $model = [
            'relations' => $relations,
            'tableName' => $tableName,
            'searchable' => $searchable,
            'sortable' => $sortable,
            'alias' => $alias,
            'fields' => $fields,
            'fieldTypes' => $fieldTypes,
            'id' => $id,
            'title' => $title,
        ];
        // return ['data' => $data, 'model' => $model];

        return view('kategori.list', compact('data', 'model'));
    }
    
    function show($id){
        $book = DB::select('select b.*, c.name as category  from books b LEFT JOIN categories c ON b.category_id = c.id WHERE b.id = ?', [$id]);
        $reviews = DB::select('select br.*, c.name as customer from book_reviews br LEFT JOIN customers c ON br.customerid = c.customerid WHERE br.book_id = ?', [$id]);
        return view('show.books', ['book' => $book[0], 'reviews' => $reviews]);
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
