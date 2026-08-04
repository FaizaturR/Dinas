<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePegawaiRequest;
use App\Http\Requests\Admin\UpdatePegawaiRequest;
use App\Models\Bidang;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('bidang')->orderBy('nama')->get();
        $bidang = Bidang::orderBy('nama')->get();
    
        $totalPegawai = $pegawai->count();
        $pegawaiAktif = $pegawai->where('status', 'aktif')->count();
        $pegawaiNonaktif = $pegawai->where('status', 'nonaktif')->count();
        $jumlahBidang = $bidang->count();
    
        return view('admin.pegawai.index', compact(
            'pegawai', 'bidang', 'totalPegawai', 'pegawaiAktif', 'pegawaiNonaktif', 'jumlahBidang'
        ));
    }

    public function store(StorePegawaiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $data['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}