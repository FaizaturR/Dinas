<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKegiatanRequest;
use App\Http\Requests\Admin\UpdateKegiatanRequest;
use App\Models\Bidang;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $bidangList = Bidang::orderBy('nama')->get();

        $filterBidang = $request->bidang ?? '';
        $filterStatus = $request->status ?? '';

        $query = Kegiatan::with('bidang');

        if ($filterBidang !== '' && ctype_digit((string) $filterBidang)) {
            $query->where('bidang_id', $filterBidang);
        }
        if (in_array($filterStatus, ['draf', 'terbit'], true)) {
            $query->where('status', $filterStatus);
        }

        $kegiatan = $query->orderByDesc('tanggal_mulai')->orderByDesc('created_at')
            ->paginate(10)->withQueryString();

        $totalKegiatan = Kegiatan::count();
        $totalTerbit = Kegiatan::where('status', 'terbit')->count();
        $totalDraft = Kegiatan::where('status', 'draf')->count();

        return view('admin.kegiatan.index', compact(
            'kegiatan', 'bidangList', 'filterBidang', 'filterStatus',
            'totalKegiatan', 'totalTerbit', 'totalDraft'
        ));
    }

    public function store(StoreKegiatanRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['slug'] = Str::slug($data['judul']) . '-' . uniqid();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        Kegiatan::create($data);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['judul']) . '-' . $kegiatan->id;

        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $kegiatan->update($data);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->gambar) {
            Storage::disk('public')->delete($kegiatan->gambar);
        }

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function perBidang(Request $request, Bidang $bidang)
    {
        $filterStatus = $request->status ?? '';

        $query = Kegiatan::where('bidang_id', $bidang->id);

        if (in_array($filterStatus, ['draf', 'terbit'], true)) {
            $query->where('status', $filterStatus);
        }

        $kegiatan = $query->orderByDesc('tanggal_mulai')->orderByDesc('created_at')
            ->paginate(10)->withQueryString();

        $totalKegiatan = Kegiatan::where('bidang_id', $bidang->id)->count();
        $totalTerbit = Kegiatan::where('bidang_id', $bidang->id)->where('status', 'terbit')->count();
        $totalDraft = Kegiatan::where('bidang_id', $bidang->id)->where('status', 'draf')->count();

        $bidangList = Bidang::orderBy('nama')->get();

        return view('admin.kegiatan.index', compact(
            'kegiatan', 'bidang', 'bidangList', 'filterStatus',
            'totalKegiatan', 'totalTerbit', 'totalDraft'
        ));
    }
}