@extends('layouts.public')
@section('title', 'Layanan Publik - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Untuk Masyarakat</div>
    <div class="section-title">Layanan Publik</div>
    <p class="section-sub">Standar pelayanan Dinas Pendidikan Kabupaten Sumenep. Klik salah satu layanan untuk melihat persyaratan, jangka waktu, biaya, dan prosedur lengkapnya.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="info-grid">
      @foreach ($daftarLayanan as $slug => $layanan)
        <a href="{{ route('layanan.detail', $slug) }}" class="info-card reveal" style="text-decoration:none;color:inherit;display:block;cursor:pointer">
          <div class="info-card-icon"><i class="bi {{ $layanan['icon'] }}"></i></div>
          <h4>{{ $layanan['judul'] }}</h4>
          <p>{{ $layanan['ringkasan'] }}</p>
          <span class="btn-next">Lihat detail <i class="bi bi-arrow-right"></i></span>
        </a>
      @endforeach
    </div>
  </div>
</section>

@endsection