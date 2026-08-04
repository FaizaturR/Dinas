@extends('layouts.public')
@section('title', 'Cek Status Pengaduan - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Layanan Aspirasi</div>
    <div class="section-title">Cek Status Pengaduan</div>
    <p class="section-sub">Masukkan nomor tiket yang Anda terima saat mengirim pengaduan untuk melihat status dan tanggapan terbaru.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner" style="max-width:760px">

    @if ($isNew && $tiket)
      <div class="tiket-alert-success reveal" style="margin-bottom:24px">
        <strong>Pengaduan berhasil dikirim!</strong> Simpan nomor tiket berikut untuk memantau status pengaduan Anda: <strong>{{ $tiket->no_tiket }}</strong>
        <div class="tiket-alert-actions">
          <a href="{{ route('pengaduan.unduh-tiket', $tiket->no_tiket) }}" class="tiket-download-btn">
            <i class="bi bi-download"></i> Unduh Bukti Tiket
          </a>
        </div>
      </div>
    @endif

    <form action="{{ route('pengaduan.cek') }}" method="GET" class="tiket-search reveal">
      <input type="text" name="no_tiket" placeholder="Masukkan nomor tiket (contoh: TK-XXXXXXXXXX)" value="{{ $noTiket }}" required>
      <button type="submit">Cek &rarr;</button>
    </form>

    @if ($noTiket !== '' && !$tiket)
      <div class="tiket-alert-error reveal">
        Nomor tiket <strong>{{ $noTiket }}</strong> tidak ditemukan. Periksa kembali penulisannya.
      </div>
    @endif

    @if ($tiket)
      <div class="tiket-card reveal">
        <div class="tiket-card-head">
          <div>
            <div class="tiket-no">#{{ $tiket->no_tiket }}</div>
            <h3>{{ $tiket->judul }}</h3>
          </div>
          <span class="status-badge status-{{ $tiket->status }}">
            {{ $statusLabel[$tiket->status] ?? $tiket->status }}
          </span>
        </div>

        <div class="tiket-meta-row">
          <span><i class="bi bi-tag"></i> {{ $kategoriLabel[$tiket->kategori] ?? $tiket->kategori }}</span>
          <span><i class="bi bi-calendar3"></i> Diajukan {{ $tiket->created_at->translatedFormat('d F Y') }}</span>
        </div>

        <p class="tiket-isi">{{ $tiket->isi }}</p>

        @if (!empty($tiket->lampiran))
          <div class="tiket-lampiran-list">
            @foreach ($tiket->lampiran as $index => $file)
              <a href="{{ Storage::url($file) }}" target="_blank" class="dokumen-btn">
                <i class="bi bi-paperclip"></i> Lampiran {{ $index + 1 }}
              </a>
            @endforeach
          </div>
        @endif

        <div class="tiket-actions">
          <a href="{{ route('pengaduan.unduh-tiket', $tiket->no_tiket) }}" class="tiket-download-btn">
            <i class="bi bi-download"></i> Unduh Bukti Tiket
          </a>
        </div>

        <div class="tanggapan-title">Tanggapan Petugas</div>
        @forelse ($tiket->tanggapan as $t)
          <div class="tanggapan-item">
            <div class="tanggapan-date">{{ $t->created_at->format('d F Y, H:i') }} WIB</div>
            <p>{{ $t->isi }}</p>
          </div>
        @empty
          <p class="tanggapan-kosong">Belum ada tanggapan dari petugas. Mohon tunggu, pengaduan Anda sedang kami proses.</p>
        @endforelse
      </div>
    @endif

  </div>
</section>

@endsection