<?php

namespace App\Http\Controllers;

class LayananController extends Controller
{
    public function publik()
    {
        $daftarLayanan = config('layanan.daftar', []);

        return view('layanan.publik', compact('daftarLayanan'));
    }

    public function detail(string $slug)
    {
        $layanan = config('layanan.daftar.' . $slug);

        return view('layanan.detail', compact('layanan', 'slug'));
    }
}