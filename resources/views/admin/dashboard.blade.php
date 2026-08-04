@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .filter-periode-card .form-inline .form-control { min-width:150px; }
    .filter-periode-label { font-size:.7rem; font-weight:800; letter-spacing:.4px; text-transform:uppercase; color:#6B7280; margin-bottom:4px; }
    .filter-mode-badge { display:inline-block; padding:4px 10px; border-radius:20px; background:#F7F4EE; border:1px solid #E5E1D8; font-size:.72rem; font-weight:700; color:#162F55; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="text-muted small">{{ $tanggalHariIni }}</div>
        </div>
    </div>

    {{-- Filter Periode --}}
    <div class="card shadow mb-4 filter-periode-card">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="filter-periode-label">Filter per Bulan</div>
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="filter" value="bulan">
                        <input type="month" name="bulan" class="form-control form-control-sm mr-2"
                            value="{{ $filterMode === 'bulan' ? $filterBulanInput : now()->format('Y-m') }}">
                        <button class="btn btn-sm btn-primary" type="submit">Terapkan</button>
                    </form>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="filter-periode-label">Filter per Hari</div>
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="filter" value="hari">
                        <input type="date" name="tanggal" class="form-control form-control-sm mr-2"
                            value="{{ $filterMode === 'hari' ? $filterHariInput : now()->format('Y-m-d') }}">
                        <button class="btn btn-sm btn-primary" type="submit">Terapkan</button>
                    </form>
                </div>
                <div class="col-md-4 text-md-right">
                    <div class="filter-periode-label">Menampilkan Data</div>
                    <span class="filter-mode-badge">{{ $labelPeriode }}</span>
                    @if ($filterMode !== 'semua')
                        <div class="mt-1"><a href="{{ route('admin.dashboard') }}" class="small">&larr; Reset ke Semua Waktu</a></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Berita</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBerita }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengumuman Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengumumanAktif }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengaduan Baru</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $pengaduanBaru }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengaduan Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanSelesai }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Pengaduan Masuk</h6>
                <span class="small text-muted">{{ $filterMode === 'semua' ? '5 pengaduan terbaru' : ('Periode: ' . $labelPeriode) }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr><th>No Tiket</th><th>Pengadu</th><th>Kategori</th><th>Status</th><th style="width:120px">Aksi</th></tr>
                        </thead>
                        <tfoot>
                            <tr><th>No Tiket</th><th>Pengadu</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr>
                        </tfoot>
                        <tbody>
                            @forelse ($pengaduanTerbaru as $p)
                                @php
                                    $kat = $kategoriLabel[$p->kategori] ?? $p->kategori;
                                    $st = $statusBadge[$p->status] ?? ['label' => $p->status, 'class' => 'badge-secondary'];
                                @endphp
                                <tr>
                                    <td>{{ $p->no_tiket }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $kat }}</td>
                                    <td><span class="badge {{ $st['class'] }}">{{ $st['label'] }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.pengaduan.unduh', $p) }}" class="btn btn-sm btn-primary" style="color:#fff;" title="Unduh laporan PDF">
                                            <i class="fas fa-file-download"></i> Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada pengaduan pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('admin-assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>$(document).ready(function () { $('#dataTable').DataTable(); });</script>
@endpush