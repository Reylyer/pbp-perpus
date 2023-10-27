<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarBuku extends Model
{
    use HasFactory;
    protected $table = 'komentar_buku';
    protected $primaryKey = 'noktp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idkomentar',
        'idbuku',
        'noktp',
        'komentar',
    ];

    public $timestamps = false;
}
