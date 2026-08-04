<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggapanPengaduan extends Model
{
    protected $table = 'tanggapan_pengaduan';

    protected $fillable = [
        'pengaduan_id',
        'admin_id',
        'isi',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}