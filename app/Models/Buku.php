<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'idbuku';
    public $incrementing = true;
    protected $fillable = [
        'isbn',
        'judul',
        'idkategori',
        'pengarang',
        'penerbit',
        'kota_terbit',
        'editor',
        'file_gambar',
        'stok',
        'stok_tersedia',
    ];

    const CREATED_AT = 'tgl_insert';
    const UPDATED_AT = 'tgl_update';

    // relations
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori');
    }

    public function getScoutKey(): mixed
    {
        return $this->isbn;
    }

    // https://learnwithdaniel.com/2022/05/laravel-scout-search-in-relationships/
    public function toSearchableArray()
    {
        $searchableArray =  [
            'isbn' => '',
            'judul' => '',
            'pengarang' => '',
            'penerbit' => '',
            'kota_terbit' => '',
            'editor' => '',
            'kategori.nama' => '',
        ];
        return $searchableArray;
    }

    public static function search($query = '', $callback = null)
    {
        return static::parentSearch($query, $callback)->query(function ($builder) {
            $builder->join('kategori', 'kategori.idkategori', '=', 'buku.idkategori')
                    ->select('buku.*', 'kategori.nama as nama_kategori');
        });
    }
}
