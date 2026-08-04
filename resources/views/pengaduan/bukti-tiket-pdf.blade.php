<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1a1a1a; }
        .title { text-align: center; font-size: 15px; font-weight: bold; margin-bottom: 2px; }
        .sub { text-align: center; font-size: 11px; margin-bottom: 10px; }
        .line { border-bottom: 2px solid #162F55; margin-bottom: 16px; }
        .no-tiket { text-align: center; font-size: 20px; font-weight: bold; color: #162F55; background: #f0f4fa; padding: 12px; border-radius: 6px; margin-bottom: 16px; }
        .baris { margin-bottom: 5px; }
        .baris .label { display: inline-block; width: 130px; font-weight: bold; }
        .baris .isi { display: inline-block; width: 65%; }
    </style>
</head>
<body>
    <div class="title">DINAS PENDIDIKAN KABUPATEN SUMENEP</div>
    <div class="sub">Bukti Tiket Pengaduan Masyarakat</div>
    <div class="line"></div>

    <div class="no-tiket">{{ $tiket->no_tiket }}</div>

    <div class="baris"><span class="label">Nama Pengadu</span>: <span class="isi">{{ $tiket->nama }}</span></div>
    <div class="baris"><span class="label">Kategori</span>: <span class="isi">{{ $kategoriLabel[$tiket->kategori] ?? $tiket->kategori }}</span></div>
    <div class="baris"><span class="label">Judul</span>: <span class="isi">{{ $tiket->judul }}</span></div>
    <div class="baris"><span class="label">Status Saat Ini</span>: <span class="isi">{{ $statusLabel[$tiket->status] ?? $tiket->status }}</span></div>
    <div class="baris"><span class="label">Tanggal Pengajuan</span>: <span class="isi">{{ $tiket->created_at->format('d-m-Y H:i') }}</span></div>

    <p style="margin-top:20px; font-style: italic; font-size: 9.5px; text-align:center;">
        Simpan nomor tiket ini untuk memantau status pengaduan Anda melalui website resmi Dinas Pendidikan Kabupaten Sumenep.
    </p>
</body>
</html>