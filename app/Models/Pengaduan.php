<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'no_tiket',
        'kategori',
        'judul',
        'isi',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'lampiran' => 'array',
    ];

    public function tanggapan()
    {
        return $this->hasMany(TanggapanPengaduan::class, 'pengaduan_id')->latest();
    }
}