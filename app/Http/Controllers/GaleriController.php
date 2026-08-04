<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriController extends Controller
{
    public function foto()
    {
        return $this->render('foto', 'Galeri Foto', 'Kumpulan dokumentasi foto kegiatan Dinas Pendidikan Kabupaten Sumenep.');
    }

    public function prestasi()
    {
        return $this->render('prestasi', 'Galeri Prestasi', 'Kumpulan dokumentasi prestasi Dinas Pendidikan Kabupaten Sumenep.');
    }

    private function render(string $kategori, string $judul, string $sub)
    {
        $galeri = Galeri::where('kategori', $kategori)
            ->orderByDesc('tanggal')
            ->paginate(8)
            ->withQueryString();

        return view('galeri.index', compact('galeri', 'kategori', 'judul', 'sub'));
    }
}