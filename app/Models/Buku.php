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
}
