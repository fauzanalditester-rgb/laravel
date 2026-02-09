<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Piutang extends Model
{
    use SoftDeletes, \App\Traits\LogsActivity;

    protected $fillable = [
        'tanggal',
        'debitur',
        'keterangan',
        'jumlah',
        'jatuh_tempo',
        'status',
        'tanggal_lunas',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
