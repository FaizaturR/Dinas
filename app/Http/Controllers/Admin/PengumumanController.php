<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePengumumanRequest;
use App\Http\Requests\Admin\UpdatePengumumanRequest;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $filterMode = in_array($request->filter, ['bulan', 'hari']) ? $request->filter : 'semua';
        $filterBulanInput = $request->bulan ?? now()->format('Y-m');
        $filterHariInput = $request->tanggal ?? now()->format('Y-m-d');

        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $labelPeriode = 'Semua Waktu';

        if ($filterMode === 'bulan' && preg_match('/^\d{4}-\d{2}$/', $filterBulanInput)) {
            [$thn, $bln] = explode('-', $filterBulanInput);
            $labelPeriode = 'Bulan ' . ($bulanList[(int) $bln] ?? $bln) . ' ' . $thn;
        } elseif ($filterMode === 'hari' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterHariInput)) {
            $labelPeriode = \Carbon\Carbon::parse($filterHariInput)->translatedFormat('l, j F Y');
        } else {
            $filterMode = 'semua';
        }

        $pengumuman = Pengumuman::latest()->get();

        $totalPengumuman = Pengumuman::count();
        $pengumumanTerbit = Pengumuman::where('status', 'terbit')->count();
        $pengumumanDraf = Pengumuman::where('status', 'draf')->count();

        return view('admin.pengumuman.index', compact(
            'pengumuman', 'totalPengumuman', 'pengumumanTerbit', 'pengumumanDraf',
            'filterMode', 'filterBulanInput', 'filterHariInput', 'labelPeriode'
        ));
    }

    public function store(StorePengumumanRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['slug'] = Str::slug($data['judul']) . '-' . uniqid();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(UpdatePengumumanRequest $request, Pengumuman $pengumuman)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['judul']) . '-' . $pengumuman->id;

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}