@extends('layouts.public')
@section('title', ($layanan['judul'] ?? 'Layanan Tidak Ditemukan') . ' - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('layanan.publik') }}" class="btn-back">&larr; Kembali ke Layanan Publik</a>

    @if (!$layanan)
      <div class="section-label">Layanan Publik</div>
      <div class="section-title">Layanan Tidak Ditemukan</div>
      <p class="section-sub">Jenis layanan yang kamu cari tidak tersedia. Silakan kembali ke daftar layanan.</p>
    @else
      <div class="section-label">Standar Pelayanan</div>
      <div class="section-title">{{ $layanan['judul'] }}</div>
      <p class="section-sub">{{ $layanan['ringkasan'] }}</p>
    @endif
  </div>
</section>

@if ($layanan)
<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner" style="max-width:900px">

    <div class="layanan-info-row reveal">
      <div class="layanan-info-box">
        <i class="bi bi-clock-history"></i>
        <div><span>Jangka Waktu</span><strong>{{ $layanan['jangka_waktu'] }}</strong></div>
      </div>
      <div class="layanan-info-box">
        <i class="bi bi-cash"></i>
        <div><span>Biaya / Tarif</span><strong>{{ $layanan['biaya'] }}</strong></div>
      </div>
      <div class="layanan-info-box">
        <i class="bi bi-file-earmark-check"></i>
        <div><span>Produk Layanan</span><strong>{{ $layanan['produk_layanan'] }}</strong></div>
      </div>
    </div>

    <div class="tiket-card reveal" style="margin-top:24px">
      <h3 style="font-size:18px;color:var(--navy);margin-bottom:16px">Persyaratan</h3>

      @if (($layanan['format'] ?? '') === 'grouped')
        @foreach ($layanan['grup_persyaratan'] as $namaGrup => $items)
          <div style="margin-bottom:20px">
            <div style="font-size:14px;font-weight:700;color:var(--gold);margin-bottom:10px">{{ $namaGrup }}</div>
            <ul style="padding-left:20px;margin:0">
              @foreach ($items as $item)
                <li style="font-size:14px;color:var(--text);line-height:1.9">{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      @else
        <ul style="padding-left:20px;margin:0">
          @foreach ($layanan['persyaratan'] as $item)
            <li style="font-size:14px;color:var(--text);line-height:1.9">{{ $item }}</li>
          @endforeach
        </ul>
      @endif
    </div>

    <div class="tiket-card reveal" style="margin-top:24px">
      <h3 style="font-size:18px;color:var(--navy);margin-bottom:20px">Prosedur dan Mekanisme</h3>
      <div class="prosedur-flow">
        @foreach ($layanan['prosedur'] as $i => $langkah)
          <div class="prosedur-step">
            <div class="prosedur-num">{{ $i + 1 }}</div>
            <div class="prosedur-label">{{ $langkah }}</div>
          </div>
          @if ($i < count($layanan['prosedur']) - 1)
            <div class="prosedur-arrow"><i class="bi bi-arrow-right"></i></div>
          @endif
        @endforeach
      </div>
    </div>

    <div class="tiket-card reveal" style="margin-top:24px">
      <h3 style="font-size:18px;color:var(--navy);margin-bottom:16px">Narahubung</h3>
      <ul style="padding-left:20px;margin:0">
        @foreach ($layanan['narahubung'] as $orang)
          <li style="font-size:14px;color:var(--text);line-height:1.9">{{ $orang }}</li>
        @endforeach
      </ul>
    </div>

  </div>
</section>
@endif

@endsection