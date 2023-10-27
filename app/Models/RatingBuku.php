<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingBuku extends Model
{
    use HasFactory;

    protected $table = 'rating_buku';
    protected $primaryKey = ['idbuku', 'noktp'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idbuku',
        'noktp',
        'skor_rating',
        'tgl_rating'
    ];

    public $timestamps = false;
}
