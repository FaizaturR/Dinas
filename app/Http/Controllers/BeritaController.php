<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengumuman;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('status', 'terbit')
            ->latest('tanggal_publish')
            ->paginate(9)
            ->withQueryString();

        $pengumuman = Pengumuman::where('status', 'terbit')->latest('tanggal')->get();

        return view('berita.index', compact('berita', 'pengumuman'));
    }

    public function show(string $slug)
    {
        $berita = Berita::where('status', 'terbit')->where('slug', $slug)->first();

        return view('berita.show', compact('berita'));
    }
}