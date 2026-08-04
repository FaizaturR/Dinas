<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';

    protected $fillable = [
        'nama',
        'tugas',
        'fungsi',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'bidang_id');
    }

    public function iconClass(): string
    {
        return match (strtolower(trim($this->nama))) {
            'sekretariat' => 'fa-building',
            'bidang paud dan pnf' => 'fa-child',
            'bidang pembinaan sd' => 'fa-school',
            'bidang pembinaan smp' => 'fa-user-graduate',
            'bidang pembinaan dan ketenagaan' => 'fa-users',
            default => 'fa-sitemap',
        };
    }
}