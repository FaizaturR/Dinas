@extends('layouts.public')

@section('title', ($berita->judul ?? 'Berita Tidak Ditemukan') . ' - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner" style="max-width:820px">
    <a href="{{ route('berita.index') }}" class="btn-back">&larr; Kembali ke Berita</a>

    @if (!$berita)
      <div class="section-label">Berita</div>
      <div class="section-title">Berita Tidak Ditemukan</div>
      <p class="section-sub">Berita yang kamu cari tidak tersedia atau belum dipublikasikan.</p>
    @else
      <div class="section-label">Berita &middot; {{ $berita->tanggal_publish?->translatedFormat('d F Y') }}</div>
      <div class="section-title" style="font-size:32px">{{ $berita->judul }}</div>
    @endif
  </div>
</section>

@if ($berita)
<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner" style="max-width:820px">

    @if ($berita->gambar)
      <div class="reveal" style="border-radius:18px;overflow:hidden;margin-bottom:32px;box-shadow:0 10px 30px rgba(11,31,58,.08)">
        <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" style="width:100%;height:auto;display:block">
      </div>
    @endif

    <div class="tiket-card reveal article-body">
      {!! $berita->isi !!}
    </div>

  </div>
</section>
@endif

@endsection