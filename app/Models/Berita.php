<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'admin_id',
        'kategori_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'status',
        'tanggal_publish',
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}