@extends('layouts.admin')

@section('title', 'Data Bidang')

@push('styles')
<style>
    .bidang-card { border:1px solid #eee0e3; border-radius:.5rem; margin-bottom:18px; overflow:hidden; }
    .bidang-card-header { background:#fff5f7; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; cursor:pointer; flex-wrap:wrap; gap:10px; }
    .bidang-card-header:hover { background:#fce9ed; }
    .bidang-icon { width:44px; height:44px; border-radius:.5rem; background:#162F55; color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
    .bidang-nama { font-weight:800; color:#4d1e2a; font-size:1rem; margin-bottom:2px; }
    .bidang-meta { font-size:.78rem; color:#9a8a8e; }
    .bidang-pegawai-count { font-size:.75rem; font-weight:700; background:#162F55; color:#fff; padding:4px 11px; border-radius:20px; }
    .bidang-card-body { padding:18px 20px; border-top:1px solid #eee0e3; }
    .bidang-section-lbl { font-size:.72rem; font-weight:800; color:#162F55; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; }
    .bidang-section-text { font-size:.88rem; color:#4d1e2a; line-height:1.6; margin-bottom:16px; }
    .bidang-actions { display:flex; gap:8px; }
    .chevron-toggle { transition:transform .2s; color:#9a8a8e; }
    .bidang-card-header.expanded .chevron-toggle { transform:rotate(180deg); }
    .modal-header-merah { background:#162F55; }
    .modal-header-merah .modal-title, .modal-header-merah .close { color:#fff; text-shadow:none; opacity:1; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Bidang</h1>
            <div class="text-muted small">Kelola bidang / unit kerja di lingkungan Dinas Pendidikan Kabupaten Sumenep.</div>
        </div>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white"
            data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Bidang
        </button>
    </div>

    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Bidang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBidang }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pegawai Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPegawai }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata Pegawai / Bidang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rataRata }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-chart-pie fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left:4px solid #162F55;">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-list mr-2" style="color:#162F55;"></i>Daftar Bidang
            </h6>
        </div>
        <div class="card-body">

            @forelse ($bidang as $b)
                <div class="bidang-card">
                    <div class="bidang-card-header" onclick="toggleBidang(this)">
                        <div class="d-flex align-items-center" style="gap:14px;">
                            <div class="bidang-icon">
                                <i class="fas {{ $b->iconClass() }}"></i>
                            </div>
                            <div>
                                <div class="bidang-nama">{{ $b->nama }}</div>
                                <div class="bidang-meta">Dibuat {{ $b->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap:12px;">
                            <span class="bidang-pegawai-count">
                                <i class="fas fa-user-friends mr-1"></i>{{ $b->pegawai_count }} Pegawai
                            </span>
                            <i class="fas fa-chevron-down chevron-toggle"></i>
                        </div>
                    </div>
                    <div class="bidang-card-body" style="display:none;">
                        <div class="bidang-section-lbl">Tugas</div>
                        <div class="bidang-section-text">
                            {!! $b->tugas ? nl2br(e($b->tugas)) : '<span class="text-muted">Belum diisi</span>' !!}
                        </div>
                        <div class="bidang-section-lbl">Fungsi</div>
                        <div class="bidang-section-text">
                            {!! $b->fungsi ? nl2br(e($b->fungsi)) : '<span class="text-muted">Belum diisi</span>' !!}
                        </div>
                        <div class="bidang-actions">
                            <button class="btn btn-sm btn-primary btn-edit"
                                onclick="event.stopPropagation();"
                                data-id="{{ $b->id }}"
                                data-nama="{{ $b->nama }}"
                                data-tugas="{{ $b->tugas }}"
                                data-fungsi="{{ $b->fungsi }}"
                                data-update-url="{{ route('admin.bidang.update', $b) }}">
                                <i class="fas fa-pen"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus"
                                onclick="event.stopPropagation();"
                                data-nama="{{ $b->nama }}"
                                data-destroy-url="{{ route('admin.bidang.destroy', $b) }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                    Belum ada data bidang.<br>
                    <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#modalTambah">
                        <i class="fas fa-plus mr-1"></i>Tambah bidang sekarang
                    </button>
                </div>
            @endforelse

        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-merah">
                    <h5 class="modal-title">Tambah Bidang</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('admin.bidang.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Nama Bidang <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="cth. Pembinaan SD" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tugas</label>
                            <textarea name="tugas" class="form-control" rows="3" placeholder="Uraikan tugas pokok bidang ini..."></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Fungsi</label>
                            <textarea name="fungsi" class="form-control" rows="3" placeholder="Uraikan fungsi bidang ini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Bidang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#162F55;">
                    <h5 class="modal-title text-white">Edit Bidang</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Nama Bidang <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="editNama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tugas</label>
                            <textarea name="tugas" id="editTugas" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Fungsi</label>
                            <textarea name="fungsi" id="editFungsi" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-white">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#e74a3b;">
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Bidang</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus bidang:</p>
                    <p class="font-weight-bold" id="hapusNama"></p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <form id="formHapus" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger ml-2"><i class="fas fa-trash mr-1"></i>Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function toggleBidang(headerEl) {
    var body = headerEl.nextElementSibling;
    var isOpen = body.style.display === 'block';
    body.style.display = isOpen ? 'none' : 'block';
    headerEl.classList.toggle('expanded', !isOpen);
}

document.querySelectorAll('.btn-edit').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('editNama').value = this.dataset.nama;
        document.getElementById('editTugas').value = this.dataset.tugas;
        document.getElementById('editFungsi').value = this.dataset.fungsi;
        document.getElementById('formEdit').action = this.dataset.updateUrl;
        $('#modalEdit').modal('show');
    });
});

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusNama').textContent = '"' + this.dataset.nama + '"';
        document.getElementById('formHapus').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush