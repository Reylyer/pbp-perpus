<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    const TABLE = "kategori";
    const ID = "idkategori";
    const TITLE = "Kategori";
    const FIELDS = ["nama"];
    const FIELD_TYPES = [
        "nama" => "s",
    ];
    const FIELD_SORTABLE = ["nama"];
    const FIELD_SEARCHABLE = ["nama"];
    const FIELD_ALIAS = [
        "nama" => "Nama",
    ];
    const FIELD_RELATIONS = [];

    // public static function list()
    // {
    //     return Kategori::all();
    // }

    // public static function find($id)
    // {
    //     return Kategori::where('idkategori', $id)->first();
    // }
}
