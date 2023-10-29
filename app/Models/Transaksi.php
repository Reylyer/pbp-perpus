<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';

    //cursed (to use ::find)
    protected $primaryKey = 'idtransaksi';
    public $incrementing = false;

    protected $fillable = [
        'idtransaksi',
        'idbuku',
        'denda',
        'idpetugas'
    ];

    public function petugas() {
        return $this->belongsTo(Petugas::class, 'idpetugas');
    }

    public function transaksi() {
        return $this->belongsTo(Transaksi::class, 'idtransaksi');
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'idbuku');
    }

    public $timestamps = false;
}
