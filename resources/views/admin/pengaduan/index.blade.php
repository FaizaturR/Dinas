@extends('layouts.admin')

@section('title', 'Pengaduan')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    #detailPengaduanModal .modal-header {
        background-color: #162F55;
        color: #fff;
        border-bottom: none;
    }

    #detailPengaduanModal .modal-header .close {
        color: #fff;
        opacity: 0.85;
        text-shadow: none;
    }

    #detailPengaduanModal .info-box {
        background: #fff5f7;
        border-radius: 0.35rem;
        padding: 10px 14px;
        height: 100%;
    }

    #detailPengaduanModal .info-box .lbl {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        color: #b48a94;
        text-transform: uppercase;
    }

    #detailPengaduanModal .info-box .val {
        font-size: 0.9rem;
        font-weight: 700;
        color: #4d1e2a;
        margin-top: 2px;
    }

    #detailPengaduanModal .section-title {
        font-size: 0.78rem;
        font-weight: 800;
        color: #162F55;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin: 18px 0 8px;
    }

    #detailPengaduanModal .isi-box {
        background: #fff5f7;
        border-radius: 0.35rem;
        padding: 14px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #4d1e2a;
    }

    #detailPengaduanModal .lampiran-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #f0e3e7;
        padding: 6px 12px;
        border-radius: 0.35rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #7b1e3d;
    }

    #detailPengaduanModal .thread-item {
        border-bottom: 1px solid #eee0e3;
        padding: 10px 0;
    }

    #detailPengaduanModal .thread-item:last-child {
        border-bottom: none;
    }

    #detailPengaduanModal .thread-item .t-head {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        margin-bottom: 4px;
    }

    #detailPengaduanModal .thread-item .t-head b {
        color: #162F55;
    }

    #detailPengaduanModal .thread-item .t-head span {
        color: #9a8a8e;
    }

    #detailPengaduanModal .thread-item .t-body {
        font-size: 0.85rem;
        color: #4d1e2a;
    }

    #detailPengaduanModal .no-thread {
        font-size: 0.85rem;
        color: #9a8a8e;
        font-style: italic;
    }

    .filter-periode-card .form-inline .form-control {
        min-width: 150px;
    }

    .filter-periode-label {
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: #6B7280;
        margin-bottom: 4px;
    }

    .filter-mode-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        background: #F7F4EE;
        border: 1px solid #E5E1D8;
        font-size: 0.72rem;
        font-weight: 700;
        color: #162F55;
    }
</style>
@endpush

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Pengaduan</h1>
        <div class="text-muted small">Kelola pengaduan masyarakat yang masuk melalui website Dinas Pendidikan Kabupaten Sumenep.</div>
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
                <div class="mt-1"><a href="{{ route('admin.pengaduan.index') }}" class="small">&larr; Reset ke Semua Waktu</a></div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">DIAJUKAN</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlDiajukan }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">DIPROSES</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlDiproses }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">DITANGGAPI</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlDitanggapi }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">SELESAI</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlSelesai }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-dark">Daftar Pengaduan</h6>
        <span class="small text-muted">{{ $filterMode === 'semua' ? '5 pengaduan terbaru' : ('Periode: ' . $labelPeriode) }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.Tiket</th>
                        <th>Pengadu</th>
                        <th>Judul Pengaduan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Pengadu</th>
                        <th>Judul Pengaduan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($daftarPengaduan as $p)
                    @php
                    $statusData = $statusInfo[$p->status] ?? ['label' => $p->status, 'badge' => 'badge-secondary'];
                    $kategoriTxt = $kategoriLabel[$p->kategori] ?? $p->kategori;
                    $lampiranItems = collect($p->lampiran ?? [])->map(fn ($file) => [
                    'nama' => $file,
                    'url' => Storage::exists('public/pengaduan/' . $file) ? Storage::url('pengaduan/' . $file) : '',
                    ]);
                    $thread = $p->tanggapan->map(fn ($t) => [
                    'admin' => $t->admin->name ?? 'Admin',
                    'waktu' => $t->created_at->format('d-m-Y H:i'),
                    'isi' => $t->isi,
                    ]);
                    @endphp
                    <tr>
                        <td>{{ $p->no_tiket }}</td>
                        <td>{{ $p->nama }}
                            <div class="text-muted small">{{ $p->email ?? '-' }}</div>
                        </td>
                        <td>{{ $p->judul }}</td>
                        <td>{{ $kategoriTxt }}</td>
                        <td>{{ $p->created_at->format('d-m-Y') }}</td>
                        <td><span class="badge {{ $statusData['badge'] }}">{{ $statusData['label'] }}</span></td>
                        <td>
                            <button style="margin:7px; padding:0px 16px;" class="btn btn-sm btn-primary"
                                onclick="showDetailPengaduan(this)"
                                data-tiket="{{ $p->no_tiket }}"
                                data-nama="{{ $p->nama }}"
                                data-email="{{ $p->email ?? '-' }}"
                                data-telepon="{{ $p->telepon ?? '-' }}"
                                data-judul="{{ $p->judul }}"
                                data-kategori="{{ $kategoriTxt }}"
                                data-tanggal="{{ $p->created_at->format('d-m-Y') }}"
                                data-status="{{ $p->status }}"
                                data-statuslabel="{{ $statusData['label'] }}"
                                data-status-class="{{ $statusData['badge'] }}"
                                data-lampiran-items="{{ $lampiranItems->toJson() }}"
                                data-tanggapi-url="{{ route('admin.pengaduan.tanggapi', $p) }}">Detail</button>

                            <textarea id="isi-data-{{ $p->id }}" style="display:none;">{{ $p->isi }}</textarea>
                            <textarea id="thread-data-{{ $p->id }}" style="display:none;">{{ $thread->toJson() }}</textarea>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pengaduan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="detailPengaduanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formTanggapi" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengaduan &mdash; <span id="dp-tiket"></span></h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters" style="gap:10px 0;">
                        <div class="col-md-3 pr-md-2 mb-2">
                            <div class="info-box">
                                <div class="lbl">Nama Pengadu</div>
                                <div class="val" id="dp-nama"></div>
                            </div>
                        </div>
                        <div class="col-md-3 px-md-1 mb-2">
                            <div class="info-box">
                                <div class="lbl">Email</div>
                                <div class="val" id="dp-email" style="font-size:.8rem;"></div>
                            </div>
                        </div>
                        <div class="col-md-3 px-md-1 mb-2">
                            <div class="info-box">
                                <div class="lbl">Telepon</div>
                                <div class="val" id="dp-telepon"></div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-md-2 mb-2">
                            <div class="info-box">
                                <div class="lbl">Kategori</div>
                                <div class="val" id="dp-kategori" style="font-size:.8rem;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters mt-1">
                        <div class="col-md-6 pr-md-2 mb-2">
                            <div class="info-box">
                                <div class="lbl">Tanggal Masuk</div>
                                <div class="val" id="dp-tanggal"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-2 mb-2">
                            <div class="info-box">
                                <div class="lbl">Status Saat Ini</div>
                                <div class="val"><span class="badge" id="dp-status-badge"></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="section-title">Judul Pengaduan</div>
                    <div class="isi-box" id="dp-judul" style="font-weight:700;"></div>

                    <div class="section-title">Isi Pengaduan</div>
                    <div class="isi-box" id="dp-isi"></div>

                    <div class="section-title">Lampiran</div>
                    <div id="dp-lampiran-wrap"></div>

                    <div class="section-title">Riwayat Tanggapan</div>
                    <div id="dp-thread"></div>

                    <div class="section-title">Kirim Tanggapan</div>
                    <textarea class="form-control" name="isi_tanggapan" id="dp-reply" rows="3" placeholder="Tulis tanggapan untuk pengadu..." required></textarea>

                    <div class="form-group mt-3 mb-0">
                        <label class="font-weight-bold small mb-1">Ubah Status</label>
                        <select class="form-control" name="status" id="dp-status-select">
                            <option value="diajukan">Diajukan</option>
                            <option value="diproses">Diproses</option>
                            <option value="ditanggapi">Ditanggapi</option>
                            <option value="ditutup">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" type="submit">Kirim Tanggapan &amp; Perbarui Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('admin-assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    function showDetailPengaduan(btn) {
        var d = btn.dataset;

        document.getElementById('dp-tiket').textContent = d.tiket;
        document.getElementById('dp-nama').textContent = d.nama;
        document.getElementById('dp-email').textContent = d.email;
        document.getElementById('dp-telepon').textContent = d.telepon;
        document.getElementById('dp-kategori').textContent = d.kategori;
        document.getElementById('dp-tanggal').textContent = d.tanggal;
        document.getElementById('dp-judul').textContent = d.judul;

        var tr = btn.closest('tr');
        var isiEl = tr.querySelector('textarea[id^="isi-data-"]');
        document.getElementById('dp-isi').textContent = isiEl ? isiEl.value : '';

        var badge = document.getElementById('dp-status-badge');
        badge.textContent = d.statuslabel;
        badge.className = 'badge ' + d.statusClass;
        document.getElementById('dp-status-select').value = d.status;

        document.getElementById('formTanggapi').action = d.tanggapiUrl;

        var lampiranWrap = document.getElementById('dp-lampiran-wrap');
        lampiranWrap.innerHTML = '';
        var lampiranItems = [];
        try {
            lampiranItems = JSON.parse(d.lampiranItems || '[]');
        } catch (e) {
            lampiranItems = [];
        }

        if (lampiranItems.length > 0) {
            lampiranItems.forEach(function(item, index) {
                if (item.url) {
                    var link = document.createElement('a');
                    link.href = item.url;
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                    link.className = 'lampiran-chip mr-2 mb-2';
                    link.style.textDecoration = 'none';
                    var icon = document.createElement('i');
                    icon.className = 'fas fa-paperclip';
                    link.appendChild(icon);
                    link.appendChild(document.createTextNode(' Lampiran ' + (index + 1)));
                    lampiranWrap.appendChild(link);
                } else {
                    var warn = document.createElement('span');
                    warn.className = 'no-thread d-block';
                    warn.textContent = 'File lampiran "' + (item.nama || 'tanpa nama') + '" tercatat, tapi tidak ditemukan di server.';
                    lampiranWrap.appendChild(warn);
                }
            });
        } else {
            lampiranWrap.innerHTML = '<span class="no-thread">Tidak ada lampiran.</span>';
        }

        var threadWrap = document.getElementById('dp-thread');
        threadWrap.innerHTML = '';
        var threadEl = tr.querySelector('textarea[id^="thread-data-"]');
        var thread = [];
        try {
            thread = JSON.parse(threadEl ? threadEl.value : '[]');
        } catch (e) {
            thread = [];
        }

        if (thread.length === 0) {
            threadWrap.innerHTML = '<div class="no-thread">Belum ada tanggapan untuk pengaduan ini.</div>';
        } else {
            thread.forEach(function(item) {
                var el = document.createElement('div');
                el.className = 'thread-item';
                var namaAdmin = document.createElement('b');
                namaAdmin.textContent = item.admin;
                var waktu = document.createElement('span');
                waktu.textContent = item.waktu;
                var head = document.createElement('div');
                head.className = 't-head';
                head.appendChild(namaAdmin);
                head.appendChild(waktu);
                var body = document.createElement('div');
                body.className = 't-body';
                body.textContent = item.isi;
                el.appendChild(head);
                el.appendChild(body);
                threadWrap.appendChild(el);
            });
        }

        document.getElementById('dp-reply').value = '';

        $('#detailPengaduanModal').modal('show');
    }
</script>
@endpush