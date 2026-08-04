<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'admin_id',
        'judul',
        'kategori',
        'gambar',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}