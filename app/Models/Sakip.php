<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sakip extends Model
{
    protected $table = 'sakip';

    protected $fillable = [
        'admin_id',
        'kategori',
        'judul',
        'tahun',
        'file',
        'keterangan',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}