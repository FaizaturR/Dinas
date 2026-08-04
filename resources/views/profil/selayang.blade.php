@extends('layouts.public')
@section('title', 'Selayang Pandang - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Profil Instansi</div>
    <div class="section-title">Selayang Pandang</div>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="profile-summary">
      <div class="profile-summary-text reveal">
        <p>{!! $profil?->selayang_pandang ? nl2br(e($profil->selayang_pandang)) : 'Informasi selayang pandang belum tersedia.' !!}</p>
      </div>
      <div class="profile-card-block reveal">
        <h3>Kontak &amp; Informasi</h3>
        <p><i class="bi bi-geo-alt"></i>&nbsp; {{ $profil?->alamat ?: '-' }}</p>
        <p><i class="bi bi-telephone"></i>&nbsp; {{ $profil?->telepon ?: '-' }}</p>
        <p><i class="bi bi-envelope"></i>&nbsp; {{ $profil?->email ?: '-' }}</p>
        @if ($profil?->facebook || $profil?->instagram || $profil?->youtube)
        <div style="display:flex;gap:12px;margin-top:14px">
          @if ($profil->facebook)<a href="{{ $profil->facebook }}" target="_blank" style="color:var(--gold)"><i class="bi bi-facebook" style="font-size:20px"></i></a>@endif
          @if ($profil->instagram)<a href="{{ $profil->instagram }}" target="_blank" style="color:var(--gold)"><i class="bi bi-instagram" style="font-size:20px"></i></a>@endif
          @if ($profil->youtube)<a href="{{ $profil->youtube }}" target="_blank" style="color:var(--gold)"><i class="bi bi-youtube" style="font-size:20px"></i></a>@endif
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection