<?php

namespace App\Http\Controllers;

class FaqController extends Controller
{
    const DATA = [
        [
            'q' => 'Bagaimana cara mendaftar PPDB (Penerimaan Peserta Didik Baru)?',
            'a' => 'Pendaftaran PPDB dapat dilakukan secara daring melalui portal PPDB resmi pada periode yang telah ditentukan. Informasi jadwal dan syarat dapat dilihat pada halaman Layanan Publik.',
        ],
        [
            'q' => 'Berapa lama proses legalisir ijazah?',
            'a' => 'Proses legalisir ijazah umumnya diselesaikan dalam 1-3 hari kerja, tergantung jumlah dokumen yang diajukan.',
        ],
        [
            'q' => 'Bagaimana cara menyampaikan pengaduan ke Dinas Pendidikan?',
            'a' => 'Pengaduan dapat disampaikan melalui menu Pengaduan pada situs ini dengan mengisi formulir yang tersedia. Anda akan mendapatkan nomor tiket untuk memantau status pengaduan.',
        ],
        [
            'q' => 'Apakah data yang saya kirimkan melalui formulir pengaduan bersifat rahasia?',
            'a' => 'Ya, data pelapor hanya digunakan untuk keperluan verifikasi dan tindak lanjut, dan tidak dipublikasikan kepada pihak yang tidak berkepentingan.',
        ],
        [
            'q' => 'Bagaimana cara mengetahui status pengajuan izin operasional sekolah?',
            'a' => 'Status pengajuan dapat ditanyakan langsung ke Bidang terkait di kantor Dinas Pendidikan, atau melalui kontak yang tercantum pada halaman Profil.',
        ],
    ];

    public function index()
    {
        return view('faq.index', ['faq' => self::DATA]);
    }
}