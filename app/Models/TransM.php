<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransM extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        'id',
        'id_produk',
        'nama_pelanggan',
        'nomor_unik',
        'nomor_polisi',
        'qty',
        'total',
        'uang_bayar',
        'uang_kembali',
        'created_at',
    ];
}
