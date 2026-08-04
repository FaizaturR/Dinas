@extends('layouts.public')

@section('title', ($pengumuman->judul ?? 'Pengumuman Tidak Ditemukan') . ' - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner" style="max-width:820px">
    <a href="{{ route('berita.index') }}" class="btn-back">&larr; Kembali ke Berita &amp; Pengumuman</a>

    @if (!$pengumuman)
      <div class="section-label">Pengumuman</div>
      <div class="section-title">Pengumuman Tidak Ditemukan</div>
      <p class="section-sub">Pengumuman yang kamu cari tidak tersedia atau belum dipublikasikan.</p>
    @else
      <div class="section-label">Pengumuman &middot; {{ $pengumuman->tanggal->translatedFormat('d F Y') }}</div>
      <div class="section-title" style="font-size:32px">{{ $pengumuman->judul }}</div>
    @endif
  </div>
</section>

@if ($pengumuman)
<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner" style="max-width:820px">

    @if ($pengumuman->gambar)
      <div class="reveal" style="border-radius:18px;overflow:hidden;margin-bottom:32px;box-shadow:0 10px 30px rgba(11,31,58,.08)">
        <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" style="width:100%;height:auto;display:block">
      </div>
    @endif

    <div class="tiket-card reveal article-body">
      {!! $pengumuman->isi !!}
    </div>

  </div>
</section>
@endif

@endsection