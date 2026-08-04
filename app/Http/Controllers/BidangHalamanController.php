<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class BidangHalamanController extends Controller
{
    const DATA = [
        'sekretariat' => [
            'nama' => 'Sekretariat',
            'deskripsi' => 'Sekretariat bertugas menyelenggarakan koordinasi pelaksanaan tugas, pembinaan, dan pemberian dukungan administrasi kepada seluruh bidang di lingkungan Dinas Pendidikan Kabupaten Sumenep, meliputi urusan umum, kepegawaian, keuangan, serta perencanaan program dan pelaporan.',
            'program' => [
                'Perencanaan program dan anggaran dinas',
                'Administrasi umum dan kepegawaian',
                'Pengelolaan keuangan dan aset',
                'Evaluasi dan pelaporan kinerja',
            ],
        ],
        'paud' => [
            'nama' => 'Bidang Pembinaan PAUD dan PNF',
            'deskripsi' => 'Bidang Pendidikan Anak Usia Dini dan Pendidikan Nonformal (PAUD dan PNF) membina satuan pendidikan usia dini (TK/RA/KB/TPA) serta layanan pendidikan nonformal seperti Paket A, B, dan C, dan lembaga kursus di wilayah Kabupaten Sumenep.',
            'program' => [
                'Pembinaan kelembagaan PAUD',
                'Peningkatan kompetensi pendidik PAUD dan PNF',
                'Penyelenggaraan pendidikan kesetaraan (Paket A, B, C)',
                'Pembinaan lembaga kursus dan pelatihan',
            ],
        ],
        'sd' => [
            'nama' => 'Bidang Pembinaan SD',
            'deskripsi' => 'Bidang Pembinaan Sekolah Dasar bertanggung jawab atas kurikulum, kesiswaan, sarana prasarana, serta mutu pendidikan pada jenjang Sekolah Dasar (SD) di seluruh Kabupaten Sumenep.',
            'program' => [
                'Pembinaan kurikulum dan pembelajaran SD',
                'Pengelolaan sarana dan prasarana sekolah',
                'Pembinaan kesiswaan dan prestasi',
                'Penjaminan mutu dan akreditasi sekolah',
            ],
        ],
        'smp' => [
            'nama' => 'Bidang Pembinaan SMP',
            'deskripsi' => 'Bidang Pembinaan Sekolah Menengah Pertama bertanggung jawab atas kurikulum, kesiswaan, sarana prasarana, serta mutu pendidikan pada jenjang Sekolah Menengah Pertama (SMP) di seluruh Kabupaten Sumenep.',
            'program' => [
                'Pembinaan kurikulum dan pembelajaran SMP',
                'Pengelolaan sarana dan prasarana sekolah',
                'Pembinaan kesiswaan dan prestasi',
                'Penjaminan mutu dan akreditasi sekolah',
            ],
        ],
        'ketenagaan' => [
            'nama' => 'Bidang Pembinaan dan Ketenagaan',
            'deskripsi' => 'Halaman ketenagaan memberikan informasi mengenai pembinaan tenaga pendidik, tenaga kependidikan, dan pengelolaan SDM pendidikan.',
            'program' => 'Pengembangan kompetensi, pendataan tenaga pendidikan, dan peningkatan kualitas layanan SDM sekolah.',
        ],
    ];

    public function show(string $slug)
    {
        abort_unless(array_key_exists($slug, self::DATA), 404);

        $data = self::DATA[$slug];

        $kegiatan = Kegiatan::whereHas('bidang', fn ($q) => $q->where('nama', $data['nama']))
            ->where('status', 'terbit')
            ->latest('tanggal_mulai')
            ->get();

        return view('bidang.show', [
            'namaBidang' => $data['nama'],
            'deskripsi' => $data['deskripsi'],
            'program' => $data['program'],
            'kegiatan' => $kegiatan,
        ]);
    }
}