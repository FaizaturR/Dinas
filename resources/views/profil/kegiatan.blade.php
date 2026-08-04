@extends('layouts.public')
@section('title', 'Kegiatan - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Dokumentasi</div>
    <div class="section-title">Kegiatan</div>
    <p class="section-sub">Dokumentasi kegiatan yang dilaksanakan oleh masing-masing bidang di Dinas Pendidikan Kabupaten Sumenep.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">

    <div class="bidang-filter">
      <a href="{{ route('profil.kegiatan') }}" class="bidang-filter-btn {{ $bidangId === 0 ? 'active' : '' }}">Semua Bidang</a>
      @foreach ($bidangList as $b)
        <a href="{{ route('profil.kegiatan', ['bidang' => $b->id]) }}" class="bidang-filter-btn {{ $bidangId === $b->id ? 'active' : '' }}">
          {{ $b->nama }}
        </a>
      @endforeach
    </div>

    <div class="kegiatan-grid">
      @forelse ($kegiatan as $row)
        <div class="kegiatan-card reveal">
          <div class="kegiatan-thumb">
            @if ($row->gambar)
              <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->judul }}">
            @else
              <div class="kegiatan-thumb-fallback"><i class="bi bi-calendar-event"></i></div>
            @endif
          </div>
          <div class="kegiatan-body">
            <div class="kegiatan-date">
              <i class="bi bi-calendar3"></i>
              {{ $row->tanggal_mulai->translatedFormat('d F Y') }}
              @if ($row->tanggal_selesai && !$row->tanggal_selesai->equalTo($row->tanggal_mulai))
                &ndash; {{ $row->tanggal_selesai->translatedFormat('d F Y') }}
              @endif
            </div>
            <h4>{{ $row->judul }}</h4>
            @if ($row->bidang)
              <span class="karyawan-badge" style="margin-bottom:8px;display:inline-block">{{ $row->bidang->nama }}</span>
            @endif
            <p>{{ Str::limit($row->deskripsi, 100) }}</p>
          </div>
        </div>
      @empty
        <div class="karyawan-empty" style="grid-column:1/-1">Belum ada kegiatan yang dipublikasikan.</div>
      @endforelse
    </div>

    @if ($kegiatan->hasPages())
      <div class="pagination">{{ $kegiatan->links() }}</div>
    @endif
  </div>
</section>

@endsection