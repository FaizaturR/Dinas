<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriRequest;
use App\Http\Requests\Admin\UpdateGaleriRequest;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function foto(Request $request)
    {
        return $this->render($request, 'foto', 'Foto');
    }

    public function prestasi(Request $request)
    {
        return $this->render($request, 'prestasi', 'Prestasi');
    }

    private function render(Request $request, string $kategori, string $label)
    {
        $filterBulan = $request->bulan ?? '';

        $query = Galeri::where('kategori', $kategori);

        if ($filterBulan !== '' && preg_match('/^\d{4}-\d{2}$/', $filterBulan)) {
            [$y, $m] = explode('-', $filterBulan);
            $query->whereYear('tanggal', $y)->whereMonth('tanggal', $m);
        }

        $galeri = $query->orderByDesc('tanggal')->orderByDesc('created_at')
            ->paginate(10)->withQueryString();

        $totalItem = Galeri::where('kategori', $kategori)->count();
        $itemBulanIni = Galeri::where('kategori', $kategori)
            ->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count();

        $bulanTersedia = Galeri::where('kategori', $kategori)
            ->selectRaw("DISTINCT DATE_FORMAT(tanggal, '%Y-%m') as bulan_key, DATE_FORMAT(tanggal, '%M %Y') as bulan_label")
            ->orderByDesc('bulan_key')->get();

        return view('admin.galeri.index', compact(
            'galeri', 'kategori', 'label', 'totalItem', 'itemBulanIni', 'bulanTersedia', 'filterBulan'
        ));
    }

    public function store(StoreGaleriRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['gambar'] = $request->file('gambar')->store('galeri', 'public');

        $galeri = Galeri::create($data);

        return redirect()->route($galeri->kategori === 'foto' ? 'admin.galeri.foto' : 'admin.galeri.prestasi')
            ->with('success', ucfirst($galeri->kategori) . ' berhasil ditambahkan.');
    }

    public function update(UpdateGaleriRequest $request, Galeri $galeri)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($galeri->gambar);
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route($galeri->kategori === 'foto' ? 'admin.galeri.foto' : 'admin.galeri.prestasi')
            ->with('success', ucfirst($galeri->kategori) . ' berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $kategori = $galeri->kategori;
        Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return redirect()->route($kategori === 'foto' ? 'admin.galeri.foto' : 'admin.galeri.prestasi')
            ->with('success', ucfirst($kategori) . ' berhasil dihapus.');
    }
}