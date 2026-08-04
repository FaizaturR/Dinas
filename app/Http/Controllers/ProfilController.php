<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Pegawai;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\Kegiatan;

class ProfilController extends Controller
{
    public function selayang()
    {
        $profil = Profil::first();

        return view('profil.selayang', compact('profil'));
    }

    public function struktur()
    {
        $profil = Profil::first();
    
        return view('profil.struktur', compact('profil'));
    }

    public function karyawan(Request $request)
    {
        $bidangId = (int) $request->get('bidang', 0);

        $query = Pegawai::with('bidang')->where('status', 'aktif');
        if ($bidangId > 0) {
            $query->where('bidang_id', $bidangId);
        }

        $pegawai = $query->oldest('id')->paginate(9)->withQueryString();
        $bidangList = Bidang::orderBy('nama')->get();

        return view('profil.karyawan', compact('pegawai', 'bidangList', 'bidangId'));
    }

    public function tupoksi()
    {
        return view('profil.tupoksi');
    }

    public function peta()
    {
        $profil = Profil::first();

        return view('profil.peta', compact('profil'));
    }

    public function kegiatan(Request $request)
    {
        $bidangId = (int) $request->get('bidang', 0);

        $query = Kegiatan::with('bidang')->where('status', 'terbit');

        if ($bidangId > 0) {
            $query->where('bidang_id', $bidangId);
        }

        $kegiatan = $query->latest('tanggal_mulai')->paginate(6)->withQueryString();
        $bidangList = Bidang::orderBy('nama')->get();

        return view('profil.kegiatan', compact('kegiatan', 'bidangList', 'bidangId'));
    }
}