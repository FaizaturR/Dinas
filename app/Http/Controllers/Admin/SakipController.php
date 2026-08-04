<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSakipRequest;
use App\Http\Requests\Admin\UpdateSakipRequest;
use App\Models\Sakip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SakipController extends Controller
{
    const KATEGORI_LABEL = [
        'renstra_pk' => 'Renstra & Perjanjian Kinerja',
        'lkjip' => 'LKjIP',
        'iku' => 'IKU',
    ];

    const KATEGORI_BADGE = [
        'renstra_pk' => 'badge-primary',
        'lkjip' => 'badge-info',
        'iku' => 'badge-warning',
    ];

    public function index(Request $request)
    {
        $filterKategori = $request->kategori ?? '';
        $filterTahun = $request->tahun ?? '';

        $query = Sakip::query();

        if ($filterKategori !== '' && array_key_exists($filterKategori, self::KATEGORI_LABEL)) {
            $query->where('kategori', $filterKategori);
        }
        if ($filterTahun !== '' && ctype_digit((string) $filterTahun)) {
            $query->where('tahun', $filterTahun);
        }

        $sakip = $query->orderByDesc('tahun')->orderByDesc('created_at')
            ->paginate(10)->withQueryString();

        $totalDokumen = Sakip::count();
        $totalRenstra = Sakip::where('kategori', 'renstra_pk')->count();
        $totalLkjip = Sakip::where('kategori', 'lkjip')->count();
        $totalIku = Sakip::where('kategori', 'iku')->count();

        $daftarTahun = Sakip::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.sakip.index', [
            'sakip' => $sakip,
            'filterKategori' => $filterKategori,
            'filterTahun' => $filterTahun,
            'totalDokumen' => $totalDokumen,
            'totalRenstra' => $totalRenstra,
            'totalLkjip' => $totalLkjip,
            'totalIku' => $totalIku,
            'daftarTahun' => $daftarTahun,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'kategoriBadge' => self::KATEGORI_BADGE,
        ]);
    }

    public function store(StoreSakipRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['file'] = $request->file('file')->store('sakip', 'public');

        Sakip::create($data);

        return redirect()->route('admin.sakip.index')->with('success', 'Dokumen SAKIP berhasil ditambahkan.');
    }

    public function update(UpdateSakipRequest $request, Sakip $sakip)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($sakip->file);
            $data['file'] = $request->file('file')->store('sakip', 'public');
        }

        $sakip->update($data);

        return redirect()->route('admin.sakip.index')->with('success', 'Dokumen SAKIP berhasil diperbarui.');
    }

    public function destroy(Sakip $sakip)
    {
        Storage::disk('public')->delete($sakip->file);
        $sakip->delete();

        return redirect()->route('admin.sakip.index')->with('success', 'Dokumen SAKIP berhasil dihapus.');
    }
}