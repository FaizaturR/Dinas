@extends('layouts.public')
@section('title', 'Peta Disdik - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('profil.selayang') }}" class="btn-back">&larr; Kembali ke Profil</a>
    <div class="section-label">Lokasi</div>
    <div class="section-title">Peta Disdik</div>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="peta-frame reveal">
      @if ($profil?->alamat)
        <iframe src="https://maps.google.com/maps?q={{ urlencode($profil->alamat) }}&output=embed"
          width="100%" height="420" style="border:0;border-radius:18px" loading="lazy"></iframe>
      @else
        <div class="struktur-empty">
          <i class="bi bi-geo-alt" style="font-size:40px;color:var(--gold);margin-bottom:14px;display:block"></i>
          Alamat belum tersedia untuk ditampilkan di peta.
        </div>
      @endif
    </div>
  </div>
</section>
@endsection