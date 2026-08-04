<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pegawai;
use App\Models\Pengumuman;
use App\Models\Profil;

class HomeController extends Controller
{
    public function index()
    {
        $profil = Profil::first();

        $beritaUtama = Berita::where('status', 'terbit')->latest('tanggal_publish')->first();
        $pengumuman = Pengumuman::where('status', 'terbit')->latest('tanggal')->take(3)->get();
        $galeri = Galeri::latest('tanggal')->take(5)->get();
        $pegawai = Pegawai::where('status', 'aktif')->oldest('id')->take(4)->get();

        return view('home', compact('profil', 'beritaUtama', 'pengumuman', 'galeri', 'pegawai'));
    }
}