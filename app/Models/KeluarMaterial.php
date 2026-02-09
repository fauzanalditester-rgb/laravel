<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeluarMaterial extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'tanggal',
        'tujuan',
        'jenis_material',
        'jumlah',
        'satuan',
        'harga_satuan',
        'total_harga',
        'keterangan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
