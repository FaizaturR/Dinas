@extends('layouts.public')
@section('title', 'FAQ - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Bantuan</div>
    <div class="section-title">FAQ</div>
    <p class="section-sub">Pertanyaan yang sering diajukan seputar layanan Dinas Pendidikan Kabupaten Sumenep.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="faq-list">
      @foreach ($faq as $f)
      <details class="faq-item reveal">
        <summary>{{ $f['q'] }}</summary>
        <p>{{ $f['a'] }}</p>
      </details>
      @endforeach
    </div>
  </div>
</section>

@endsection