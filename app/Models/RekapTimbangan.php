<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class RekapTimbangan extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'tanggal',
        'nomor_kendaraan',
        'jenis_material',
        'berat_masuk',
        'berat_keluar',
        'berat_bersih',
        'keterangan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
