@extends('layouts.public')
@section('title', 'Data Karyawan - Dinas Pendidikan Kabupaten Sumenep')
@section('content')

<section class="section" style="padding-bottom:10px">
  <div class="section-inner">
    <a href="{{ route('home') }}" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="section-label">Sumber Daya Manusia</div>
    <div class="section-title">Data Karyawan</div>
  </div>
</section>

<section class="section section-alt" style="padding-top:20px">
  <div class="section-inner">
    <div class="bidang-filter">
      <a href="{{ route('profil.karyawan') }}" class="bidang-filter-btn {{ $bidangId === 0 ? 'active' : '' }}">Semua Bidang</a>
      @foreach ($bidangList as $b)
        <a href="{{ route('profil.karyawan', ['bidang' => $b->id]) }}" class="bidang-filter-btn {{ $bidangId === $b->id ? 'active' : '' }}">
          {{ $b->nama }}
        </a>
      @endforeach
    </div>

    <div class="karyawan-grid">
      @forelse ($pegawai as $row)
        @php
            $kata = preg_split('/\s+/', trim($row->nama));
            $inisial = strtoupper(substr($kata[0], 0, 1)) . (count($kata) > 1 ? strtoupper(substr(end($kata), 0, 1)) : '');
        @endphp
        <div class="karyawan-card reveal">
          <div class="karyawan-avatar">
            @if ($row->foto)
              <img src="{{ Storage::url($row->foto) }}" alt="{{ $row->nama }}">
            @else
              <div class="karyawan-avatar-fallback">{{ $inisial }}</div>
            @endif
          </div>
          <div class="karyawan-body">
            <div class="karyawan-name">{{ $row->nama }}</div>
            <div class="karyawan-role">{{ $row->jabatan }}</div>
            @if ($row->bidang)
              <span class="karyawan-badge">{{ $row->bidang->nama }}</span>
            @endif
            <div class="karyawan-meta">
              @if ($row->nip)<span><strong>NIP</strong> {{ $row->nip }}</span>@endif
              @if ($row->email)<span><strong>Email</strong> {{ $row->email }}</span>@endif
            </div>
          </div>
        </div>
      @empty
        <div class="karyawan-empty">Belum ada data karyawan.</div>
      @endforelse
    </div>

    @if ($pegawai->hasPages())
      <div class="pagination">{{ $pegawai->links() }}</div>
    @endif
  </div>
</section>
@endsection