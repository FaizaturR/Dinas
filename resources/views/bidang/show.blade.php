@extends('layouts.public')

@section('title', $namaBidang . ' - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<section class="section">
  <div class="section-inner">
    <div class="section-head">
      <div>
        <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
        <div class="section-label">Bidang</div>
        <div class="section-title">{{ $namaBidang }}</div>
      </div>
    </div>

    <div class="profile-summary reveal">
      <div class="profile-summary-text">
        <p>{{ $deskripsi }}</p>
      </div>
      <div class="profile-card-block">
        <h3>Program Utama</h3>
        @if (is_array($program))
          <ul>
            @foreach ($program as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ul>
        @else
          <p>{{ $program }}</p>
        @endif
      </div>
    </div>

    <div style="margin-top:40px">
      <h3 class="kegiatan-bidang-title reveal">Kegiatan Pada Bidang {{ $namaBidang }}</h3>
    
      <div class="kegiatan-grid">
        @forelse ($kegiatan as $row)
          <div class="kegiatan-card reveal">
            <div class="kegiatan-thumb">
              @if ($row->gambar)
                <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->judul }}">
              @else
                <div class="kegiatan-thumb-fallback"><i class="bi bi-calendar-event"></i></div>
              @endif
            </div>
            <div class="kegiatan-body">
              <div class="kegiatan-date">
                <i class="bi bi-calendar3"></i>
                {{ $row->tanggal_mulai->translatedFormat('d F Y') }}
                @if ($row->tanggal_selesai && !$row->tanggal_selesai->equalTo($row->tanggal_mulai))
                  &ndash; {{ $row->tanggal_selesai->translatedFormat('d F Y') }}
                @endif
              </div>
              <h4>{{ $row->judul }}</h4>
              <p>{{ Str::limit($row->deskripsi, 100) }}</p>
            </div>
          </div>
        @empty
          <div class="karyawan-empty" style="grid-column:1/-1">Belum ada kegiatan yang dipublikasikan.</div>
        @endforelse
      </div>
    </div>
  </div>
</section>

@endsection