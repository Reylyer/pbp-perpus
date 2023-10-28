<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'idtransaksi',
        'idbuku',
        'denda',
        'idpetugas'
    ];

    public function petugas() {
        return $this->belongsTo('idpetugas');
    }

    public function transaksi() {
        return $this->belongsTo('idtransaksi');
    }

    public function buku() {
        return $this->belongsTo('idbuku');
    }

    public $timestamps = false;
}
