<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'nomor_invoice',
        'tanggal',
        'customer',
        'jenis_material',
        'jumlah',
        'satuan',
        'harga_satuan',
        'total_harga',
        'status_bayar',
        'keterangan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
