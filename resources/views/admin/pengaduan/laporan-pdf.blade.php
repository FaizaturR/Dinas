<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10.5px; color: #1a1a1a; }
        .header-title { text-align: center; font-size: 15px; font-weight: bold; margin-bottom: 2px; }
        .header-sub { text-align: center; font-size: 11px; margin-bottom: 8px; }
        .header-line { border-bottom: 2px solid #162F55; margin-bottom: 14px; }
        .subjudul { background: #f0f4fa; padding: 6px 8px; font-weight: bold; font-size: 12px; margin: 10px 0 6px; }
        .baris { margin-bottom: 4px; }
        .baris .label { display: inline-block; width: 130px; font-weight: bold; vertical-align: top; }
        .baris .colon { display: inline-block; width: 10px; }
        .baris .isi { display: inline-block; width: 70%; vertical-align: top; }
        .isi-panjang { white-space: pre-wrap; margin-top: 4px; }
        .tanggapan-item { margin-bottom: 8px; }
        .tanggapan-head { font-weight: bold; font-size: 10.5px; }
        .tanggapan-body { margin-left: 10px; margin-top: 2px; white-space: pre-wrap; }
        .footer-note { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 8.5px; color: #787878; font-style: italic; }
    </style>
</head>
<body>

    <div class="header-title">DINAS PENDIDIKAN KABUPATEN SUMENEP</div>
    <div class="header-sub">Laporan Detail Pengaduan</div>
    <div class="header-line"></div>

    <div class="subjudul">Data Pengaduan</div>
    <div class="baris"><span class="label">No. Tiket</span><span class="colon">:</span><span class="isi">{{ $pengaduan->no_tiket }}</span></div>
    <div class="baris"><span class="label">Nama Pengadu</span><span class="colon">:</span><span class="isi">{{ $pengaduan->nama }}</span></div>
    <div class="baris"><span class="label">Email</span><span class="colon">:</span><span class="isi">{{ $pengaduan->email ?: '-' }}</span></div>
    <div class="baris"><span class="label">Telepon</span><span class="colon">:</span><span class="isi">{{ $pengaduan->telepon ?: '-' }}</span></div>
    <div class="baris"><span class="label">Kategori</span><span class="colon">:</span><span class="isi">{{ $kategoriLabel[$pengaduan->kategori] ?? $pengaduan->kategori }}</span></div>
    <div class="baris"><span class="label">Status Saat Ini</span><span class="colon">:</span><span class="isi">{{ $statusInfo[$pengaduan->status]['label'] ?? $pengaduan->status }}</span></div>
    <div class="baris"><span class="label">Tanggal Masuk</span><span class="colon">:</span><span class="isi">{{ $pengaduan->created_at->format('d-m-Y H:i') }}</span></div>

    <div class="subjudul">Isi Pengaduan</div>
    <div style="font-weight: bold;">{{ $pengaduan->judul }}</div>
    <div class="isi-panjang">{{ $pengaduan->isi }}</div>

    @if (!empty($pengaduan->lampiran))
        <div style="margin-top: 6px; font-style: italic; font-size: 9.5px;">
            Lampiran: {{ collect($pengaduan->lampiran)->implode(', ') }}
        </div>
    @endif

    <div class="subjudul">Riwayat Tanggapan ({{ $pengaduan->tanggapan->count() }})</div>
    @forelse ($pengaduan->tanggapan as $i => $t)
        <div class="tanggapan-item">
            <div class="tanggapan-head">{{ $i + 1 }}. {{ $t->admin->name ?? 'Admin' }} - {{ $t->created_at->format('d-m-Y H:i') }}</div>
            <div class="tanggapan-body">{{ $t->isi }}</div>
        </div>
    @empty
        <div style="font-style: italic;">Belum ada tanggapan untuk pengaduan ini.</div>
    @endforelse

    <div class="footer-note">
        Dicetak pada {{ now()->format('d-m-Y H:i') }} oleh sistem admin Disdik Sumenep
    </div>

</body>
</html>