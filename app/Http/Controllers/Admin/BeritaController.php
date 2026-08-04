<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $filterMode = in_array($request->filter, ['bulan', 'hari']) ? $request->filter : 'semua';
        $filterBulanInput = $request->bulan ?? now()->format('Y-m');
        $filterHariInput = $request->tanggal ?? now()->format('Y-m-d');

        $query = Berita::with('kategori');
        $labelPeriode = 'Semua Waktu';

        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        if ($filterMode === 'bulan' && preg_match('/^\d{4}-\d{2}$/', $filterBulanInput)) {
            [$thn, $bln] = explode('-', $filterBulanInput);
            $query->whereMonth('created_at', (int) $bln)->whereYear('created_at', (int) $thn);
            $labelPeriode = 'Bulan ' . ($bulanList[(int) $bln] ?? $bln) . ' ' . $thn;
        } elseif ($filterMode === 'hari' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterHariInput)) {
            $query->whereDate('created_at', $filterHariInput);
            $labelPeriode = \Carbon\Carbon::parse($filterHariInput)->translatedFormat('l, j F Y');
        } else {
            $filterMode = 'semua';
        }

        $berita = $query->latest()->when($filterMode === 'semua', fn ($q) => $q->limit(5))->get();

        $kategoriList = KategoriBerita::orderBy('nama')->get();

        $totalBerita = Berita::count();
        $beritaTerbit = Berita::where('status', 'terbit')->count();
        $beritaDraft = Berita::where('status', 'draf')->count();

        return view('admin.berita.index', compact(
            'berita', 'kategoriList', 'totalBerita', 'beritaTerbit', 'beritaDraft',
            'filterMode', 'filterBulanInput', 'filterHariInput', 'labelPeriode'
        ));
    }

    public function store(StoreBeritaRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['slug'] = Str::slug($data['judul']) . '-' . uniqid();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(UpdateBeritaRequest $request, Berita $berita)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['judul']) . '-' . $berita->id;

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function storeKategoriAjax(Request $request)
    {
        $request->validate(['nama' => ['required', 'string', 'max:100']]);

        $kategori = KategoriBerita::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
        ]);

        return response()->json(['success' => true, 'id' => $kategori->id, 'nama' => $kategori->nama]);
    }
}