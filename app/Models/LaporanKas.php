<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanKas extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'tanggal',
        'jenis',      // masuk, keluar
        'kategori',   // operasional, gaji, penjualan, dll
        'keterangan',
        'jumlah',
        'saldo',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
