<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengaduan;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    const KATEGORI_LABEL = [
        'sarana_prasarana' => 'Sarana & Prasarana',
        'kepegawaian' => 'Kepegawaian',
        'pelayanan' => 'Pelayanan',
        'lainnya' => 'Lainnya',
    ];

    const STATUS_BADGE = [
        'diajukan' => ['label' => 'Diajukan', 'class' => 'badge-warning'],
        'diproses' => ['label' => 'Diproses', 'class' => 'badge-info'],
        'ditanggapi' => ['label' => 'Ditanggapi', 'class' => 'badge-primary'],
        'ditutup' => ['label' => 'Selesai', 'class' => 'badge-success'],
    ];

    public function index(Request $request)
    {
        $tanggalHariIni = now()->translatedFormat('l, j F Y');

        $filterMode = in_array($request->filter, ['bulan', 'hari']) ? $request->filter : 'semua';
        $filterBulanInput = $request->bulan ?? now()->format('Y-m');
        $filterHariInput = $request->tanggal ?? now()->format('Y-m-d');

        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $labelPeriode = 'Semua Waktu';

        $beritaQuery = Berita::query();
        $pengumumanQuery = Pengumuman::where('status', 'terbit');
        $pengaduanQuery = Pengaduan::query();

        if ($filterMode === 'bulan' && preg_match('/^\d{4}-\d{2}$/', $filterBulanInput)) {
            [$thn, $bln] = explode('-', $filterBulanInput);
            $beritaQuery->whereMonth('created_at', (int) $bln)->whereYear('created_at', (int) $thn);
            $pengumumanQuery->whereMonth('tanggal', (int) $bln)->whereYear('tanggal', (int) $thn);
            $pengaduanQuery->whereMonth('created_at', (int) $bln)->whereYear('created_at', (int) $thn);
            $labelPeriode = 'Bulan ' . ($bulanList[(int) $bln] ?? $bln) . ' ' . $thn;
        } elseif ($filterMode === 'hari' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterHariInput)) {
            $beritaQuery->whereDate('created_at', $filterHariInput);
            $pengumumanQuery->whereDate('tanggal', $filterHariInput);
            $pengaduanQuery->whereDate('created_at', $filterHariInput);
            $labelPeriode = \Carbon\Carbon::parse($filterHariInput)->translatedFormat('l, j F Y');
        } else {
            $filterMode = 'semua';
        }

        $totalBerita = $beritaQuery->count();
        $pengumumanAktif = $pengumumanQuery->count();
        $pengaduanBaru = (clone $pengaduanQuery)->where('status', 'diajukan')->count();
        $pengaduanSelesai = (clone $pengaduanQuery)->where('status', 'ditutup')->count();

        $pengaduanTerbaru = (clone $pengaduanQuery)
            ->latest()
            ->when($filterMode === 'semua', fn ($q) => $q->limit(5))
            ->get(['id', 'no_tiket', 'nama', 'kategori', 'status']);

        return view('admin.dashboard', [
            'tanggalHariIni' => $tanggalHariIni,
            'filterMode' => $filterMode,
            'filterBulanInput' => $filterBulanInput,
            'filterHariInput' => $filterHariInput,
            'labelPeriode' => $labelPeriode,
            'totalBerita' => $totalBerita,
            'pengumumanAktif' => $pengumumanAktif,
            'pengaduanBaru' => $pengaduanBaru,
            'pengaduanSelesai' => $pengaduanSelesai,
            'pengaduanTerbaru' => $pengaduanTerbaru,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'statusBadge' => self::STATUS_BADGE,
        ]);
    }
}