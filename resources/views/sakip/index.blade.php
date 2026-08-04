@extends('layouts.public')
@section('title', 'Sakip - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Akuntabilitas Kinerja</div>
    <div class="section-title">Sakip</div>
    <p class="section-sub">Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) merupakan rangkaian sistematik dari perencanaan, pengukuran, pelaporan, dan evaluasi kinerja instansi pemerintah.</p>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">

    <div class="bidang-filter">
      <a href="{{ route('sakip.index') }}" class="bidang-filter-btn {{ $filter === '' ? 'active' : '' }}">Semua Kategori</a>
      @foreach (\App\Http\Controllers\SakipController::KATEGORI_LABEL as $kode => $label)
        <a href="{{ route('sakip.index', ['kategori' => $kode]) }}" class="bidang-filter-btn {{ $filter === $kode ? 'active' : '' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>

    @foreach ($kategoriTampil as $kode => $label)
      <div style="margin-bottom:40px">
        <div class="section-label" style="margin-bottom:16px">{{ $label }}</div>

        <div class="dokumen-list">
          @forelse ($dokumenPerKategori[$kode] as $d)
            <div class="dokumen-item reveal">
              <div class="dokumen-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
              <div class="dokumen-info">
                <h5>{{ $d->judul }}</h5>
                <span>
                  Tahun {{ $d->tahun }}
                  @if ($d->keterangan) &middot; {{ $d->keterangan }} @endif
                </span>
              </div>
              <div class="dokumen-actions">
                <a href="{{ Storage::url($d->file) }}" target="_blank" class="dokumen-btn dokumen-btn-outline">Lihat</a>
                <a href="{{ Storage::url($d->file) }}" class="dokumen-btn" download>Unduh</a>
              </div>
            </div>
          @empty
            <div class="karyawan-empty">Belum ada dokumen pada kategori ini.</div>
          @endforelse
        </div>
      </div>
    @endforeach

  </div>
</section>

@endsection