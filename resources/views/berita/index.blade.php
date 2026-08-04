@extends('layouts.public')

@section('title', 'Berita & Pengumuman - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Informasi Terkini</div>
    <div class="section-title">Berita &amp; Pengumuman</div>
    <p class="section-sub">Kumpulan berita dan pengumuman resmi Dinas Pendidikan Kabupaten Sumenep.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">

    <div class="section-head" style="margin-bottom:24px">
      <div><div class="section-label">Berita</div></div>
    </div>

    <div class="kegiatan-grid">
      @forelse ($berita as $row)
        <div class="kegiatan-card reveal">
          <div class="kegiatan-thumb">
            @if ($row->gambar)
              <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->judul }}">
            @else
              <div class="kegiatan-thumb-fallback"><i class="bi bi-newspaper"></i></div>
            @endif
          </div>
          <div class="kegiatan-body">
            <div class="kegiatan-date"><i class="bi bi-calendar3"></i> {{ $row->tanggal_publish?->translatedFormat('d F Y') }}</div>
            <h4>{{ $row->judul }}</h4>
            <p>{{ Str::limit(strip_tags($row->isi), 100) }}</p>
            <a href="{{ route('berita.show', $row->slug) }}" class="read-more">Baca selengkapnya</a>
          </div>
        </div>
      @empty
        <div class="karyawan-empty" style="grid-column:1/-1">Belum ada berita yang dipublikasikan.</div>
      @endforelse
    </div>

    @if ($berita->hasPages())
      <div class="pagination">{{ $berita->links() }}</div>
    @endif

    <div class="section-head" style="margin:56px 0 24px">
      <div><div class="section-label">Pengumuman</div></div>
    </div>

    <div class="news-sidebar">
      @forelse ($pengumuman as $row)
        <a href="{{ route('pengumuman.show', $row->slug) }}" class="news-list-card reveal" style="text-decoration:none;color:inherit;display:block">
          <div class="news-badge sidebar-badge" style="background:#166534;">Info</div>
          <div class="news-list-item">
            <h4>{{ $row->judul }}</h4>
            <span>{{ $row->tanggal->translatedFormat('d F Y') }}</span>
          </div>
        </a>
      @empty
        <div class="news-list-card reveal">
          <div class="news-list-item"><h4>Belum ada pengumuman.</h4></div>
        </div>
      @endforelse
    </div>
  </div>
</section>

@endsection