@extends('layouts.public')

@section('title', $judul . ' - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Dokumentasi</div>
    <div class="section-title">{{ $judul }}</div>
    <p class="section-sub">{{ $sub }}</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="galeri-full-grid">
      @forelse ($galeri as $row)
        <div class="galeri-full-item reveal" onclick="openLightbox('{{ Storage::url($row->gambar) }}')">
          <div class="galeri-full-thumb">
            <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->judul }}">
          </div>
          <div class="galeri-full-body">
            <div class="galeri-full-date"><i class="bi bi-calendar3"></i> {{ $row->tanggal->translatedFormat('d F Y') }}</div>
            <h5>{{ $row->judul }}</h5>
          </div>
        </div>
      @empty
        <div class="karyawan-empty" style="grid-column:1/-1">Belum ada {{ strtolower($judul) }} pada galeri ini.</div>
      @endforelse
    </div>

    @if ($galeri->hasPages())
      <div class="pagination">
        {{ $galeri->onEachSide(2)->links('pagination::simple-bootstrap-4') }}
      </div>
    @endif
  </div>
</section>

@endsection