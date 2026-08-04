<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = 'profil';
    protected $touches = [];
    public $timestamps = true;
    const CREATED_AT = null;

    protected $fillable = [
        'selayang_pandang',
        'visi',
        'misi',
        'alamat',
        'telepon',
        'email',
        'facebook',
        'youtube',
        'instagram',
        'tiktok',
        'struktur_organisasi',
    ];
}