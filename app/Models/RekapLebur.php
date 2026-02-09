<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapLebur extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'tanggal',
        'jenis_material',
        'berat_awal',
        'berat_hasil',
        'susut',
        'persentase_susut',
        'keterangan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
