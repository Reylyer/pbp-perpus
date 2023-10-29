<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'idtransaksi';

    protected $fillable = [
        'noktp',
        'idbuku',
        'idpetugas',
    ];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'idtransaksi');
    }

    const CREATED_AT = 'tgl_pinjam';
    const UPDATED_AT = null;
}
