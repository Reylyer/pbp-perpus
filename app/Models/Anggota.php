<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';
    protected $primaryKey = 'noktp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'noktp',
        'nama',
        'password',
        'alamat',
        'kota',
        'email',
        'no_telp',
        'file_ktp'
    ];

    public $timestamps = false;

}
