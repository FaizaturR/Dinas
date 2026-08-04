<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTanggapanRequest;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PengaduanController extends Controller
{
    const KATEGORI_LABEL = [
        'sarana_prasarana' => 'Sarana & Prasarana',
        'kepegawaian' => 'Kepegawaian',
        'pelayanan' => 'Pelayanan',
        'lainnya' => 'Lainnya',
    ];

    const STATUS_INFO = [
        'diajukan' => ['label' => 'Diajukan', 'badge' => 'badge-warning'],
        'diproses' => ['label' => 'Diproses', 'badge' => 'badge-info'],
        'ditanggapi' => ['label' => 'Ditanggapi', 'badge' => 'badge-primary'],
        'ditutup' => ['label' => 'Selesai', 'badge' => 'badge-success'],
    ];

    public function index(Request $request)
    {
        $filterMode = in_array($request->filter, ['bulan', 'hari']) ? $request->filter : 'semua';
        $filterBulanInput = $request->bulan ?? now()->format('Y-m');
        $filterHariInput = $request->tanggal ?? now()->format('Y-m-d');

        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $labelPeriode = 'Semua Waktu';

        $query = Pengaduan::with(['tanggapan.admin']);

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

        $daftarPengaduan = $query->latest()
            ->when($filterMode === 'semua', fn ($q) => $q->limit(5))
            ->get();

        $jmlDiajukan = Pengaduan::where('status', 'diajukan')->count();
        $jmlDiproses = Pengaduan::where('status', 'diproses')->count();
        $jmlDitanggapi = Pengaduan::where('status', 'ditanggapi')->count();
        $jmlSelesai = Pengaduan::where('status', 'ditutup')->count();

        return view('admin.pengaduan.index', [
            'daftarPengaduan' => $daftarPengaduan,
            'filterMode' => $filterMode,
            'filterBulanInput' => $filterBulanInput,
            'filterHariInput' => $filterHariInput,
            'labelPeriode' => $labelPeriode,
            'jmlDiajukan' => $jmlDiajukan,
            'jmlDiproses' => $jmlDiproses,
            'jmlDitanggapi' => $jmlDitanggapi,
            'jmlSelesai' => $jmlSelesai,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'statusInfo' => self::STATUS_INFO,
        ]);
    }

    public function tanggapi(StoreTanggapanRequest $request, Pengaduan $pengaduan)
    {
        $pengaduan->tanggapan()->create([
            'admin_id' => auth()->id(),
            'isi' => $request->isi_tanggapan,
        ]);

        $pengaduan->update(['status' => $request->status]);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Tanggapan terkirim dan status berhasil diperbarui.');
    }

    public function unduh(Pengaduan $pengaduan)
    {
        $pengaduan->load('tanggapan.admin');
    
        $namaFile = 'laporan_pengaduan_' . preg_replace('/[^A-Za-z0-9_-]/', '', $pengaduan->no_tiket) . '.pdf';
    
        $pdf = Pdf::loadView('admin.pengaduan.laporan-pdf', [
            'pengaduan' => $pengaduan,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'statusInfo' => self::STATUS_INFO,
        ])->setPaper('a4');
    
        return $pdf->download($namaFile);
    }
}