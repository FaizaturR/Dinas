<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengaduanRequest;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    const KATEGORI_LABEL = [
        'sarana_prasarana' => 'Sarana & Prasarana',
        'kepegawaian' => 'Kepegawaian',
        'pelayanan' => 'Pelayanan',
        'lainnya' => 'Lainnya',
    ];

    const STATUS_LABEL = [
        'diajukan' => 'Diajukan',
        'diproses' => 'Diproses',
        'ditanggapi' => 'Ditanggapi',
        'ditutup' => 'Selesai',
    ];

    public function create()
    {
        return redirect()->route('home') . '#pengaduan';
    }

    public function store(StorePengaduanRequest $request)
    {
        $data = $request->validated();
        $data['no_tiket'] = $this->generateNoTiket();

        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('pengaduan', 'public');
            }
        }
        $data['lampiran'] = $lampiranPaths;

        $pengaduan = Pengaduan::create($data);

        return redirect()->route('pengaduan.cek', ['no_tiket' => $pengaduan->no_tiket, 'new' => 1]);
    }

    public function cek(Request $request)
    {
        $noTiket = trim((string) $request->get('no_tiket', ''));
        $isNew = $request->get('new') == '1';

        $tiket = $noTiket !== ''
            ? Pengaduan::with('tanggapan')->where('no_tiket', $noTiket)->first()
            : null;

        return view('pengaduan.cek', [
            'noTiket' => $noTiket,
            'isNew' => $isNew,
            'tiket' => $tiket,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'statusLabel' => self::STATUS_LABEL,
        ]);
    }

    public function unduhTiket(string $no_tiket)
    {
        $tiket = Pengaduan::with('tanggapan')->where('no_tiket', $no_tiket)->firstOrFail();

        $pdf = Pdf::loadView('pengaduan.bukti-tiket-pdf', [
            'tiket' => $tiket,
            'kategoriLabel' => self::KATEGORI_LABEL,
            'statusLabel' => self::STATUS_LABEL,
        ])->setPaper('a4');

        return $pdf->download('bukti-tiket-' . $tiket->no_tiket . '.pdf');
    }

    private function generateNoTiket(): string
    {
        do {
            $tiket = 'TK-' . Str::upper(Str::random(10));
        } while (Pengaduan::where('no_tiket', $tiket)->exists());

        return $tiket;
    }
}