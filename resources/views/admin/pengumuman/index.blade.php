@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .stat-card {
        border-left: 4px solid #162F55;
    }

    .badge-terbit {
        background: #d4edda;
        color: #155724;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-draf {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .img-thumb {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        background: #f0f0f0;
    }

    .img-thumb-placeholder {
        width: 70px;
        height: 50px;
        background: #e9ecef;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }

    .filter-periode-card .form-inline .form-control {
        min-width: 150px;
    }

    .filter-periode-label {
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .4px;
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
        font-size: .72rem;
        font-weight: 700;
        color: #162F55;
    }
</style>
@endpush

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Pengumuman</h1>
        <div class="text-muted small">Kelola pengumuman resmi Dinas Pendidikan Kabupaten Sumenep.</div>
    </div>
    <button class="btn btn-sm btn-primary shadow-sm text-white" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus fa-sm text-white"></i> Tambah Pengumuman
    </button>
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
                <div class="mt-1"><a href="{{ route('admin.pengumuman.index') }}" class="small">&larr; Reset ke Semua Waktu</a></div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#162F55;">Total Pengumuman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengumuman }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-bullhorn fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card shadow h-100 py-2" style="border-left:4px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terbit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengumumanTerbit }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card shadow h-100 py-2" style="border-left:4px solid #e74a3b;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Draf</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengumumanDraf }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" style="border-left:4px solid #162F55;">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-list mr-2" style="color:#162F55;"></i>Daftar Pengumuman
        </h6>
        <span class="small text-muted">{{ $filterMode === 'semua' ? '5 pengumuman terbaru' : ('Periode: ' . $labelPeriode) }}</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="60">#</th>
                        <th width="90">Gambar</th>
                        <th>Judul Pengumuman</th>
                        <th width="110">Status</th>
                        <th width="120">Tanggal</th>
                        <th width="130" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengumuman as $i => $row)
                    <tr>
                        <td class="text-center align-middle text-muted small">{{ $i + 1 }}</td>
                        <td class="text-center align-middle">
                            @if ($row->gambar)
                            <img src="{{ Storage::url($row->gambar) }}" alt="Gambar" class="img-thumb">
                            @else
                            <div class="img-thumb-placeholder mx-auto"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td class="align-middle">{{ $row->judul }}</td>
                        <td class="align-middle text-center">
                            @if ($row->status === 'terbit')
                            <span class="badge-terbit">Terbit</span>
                            @else
                            <span class="badge-draf">Draf</span>
                            @endif
                        </td>
                        <td class="align-middle text-center small text-muted">{{ $row->tanggal->format('d M Y') }}</td>
                        <td class="align-middle text-center">
                            <button class="btn btn-sm btn-edit btn-primary"
                                data-judul="{{ $row->judul }}"
                                data-isi="{{ $row->isi }}"
                                data-tanggal="{{ $row->tanggal->format('Y-m-d') }}"
                                data-status="{{ $row->status }}"
                                data-gambar="{{ $row->gambar ? Storage::url($row->gambar) : '' }}"
                                data-update-url="{{ route('admin.pengumuman.update', $row) }}"
                                title="Edit" style="padding:4px 8px;">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-hapus ml-1"
                                data-judul="{{ $row->judul }}"
                                data-destroy-url="{{ route('admin.pengumuman.destroy', $row) }}"
                                title="Hapus" style="padding:4px 8px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada pengumuman. Klik <strong>+ Tambah Pengumuman</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#162F55;">
                <h5 class="modal-title text-white">Tambah Pengumuman</h5>
                <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="terbit">Terbit</option>
                                    <option value="draf">Draf</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Gambar <span class="text-muted font-weight-normal">(opsional)</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGambarTambah" name="gambar" accept="image/*">
                            <label class="custom-file-label" for="inputGambarTambah">Pilih gambar...</label>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                        <img id="previewGambar" src="" alt="Preview" style="display:none; max-height:150px; margin-top:8px; border-radius:6px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pengumuman</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header btn-primary">
                <h5 class="modal-title text-white">Edit Pengumuman</h5>
                <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditPengumuman" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="editJudul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" id="editIsi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="editTanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" id="editStatus" class="form-control">
                                    <option value="terbit">Terbit</option>
                                    <option value="draf">Draf</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Ganti Gambar <span class="text-muted font-weight-normal">(kosongkan jika tidak ingin ganti)</span></label>
                        <div id="gambarLamaContainer" class="mb-2" style="display:none;">
                            <small class="text-muted">Gambar saat ini:</small><br>
                            <img id="previewGambarEdit" src="" style="max-height:150px;border-radius:6px;">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGambarEdit" name="gambar" accept="image/*">
                            <label class="custom-file-label" for="inputGambarEdit">Pilih gambar baru...</label>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
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
                <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Pengumuman</h5>
                <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p>Yakin ingin menghapus pengumuman:</p>
                <p class="font-weight-bold" id="hapusJudul"></p>
            </div>
            <div class="modal-footer">
                <form id="formHapusPengumuman" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i>Hapus</button>
                </form>
            </div>
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

    document.getElementById('inputGambarTambah').addEventListener('change', function() {
        var file = this.files[0];
        var label = this.nextElementSibling;
        var preview = document.getElementById('previewGambar');
        if (file) {
            label.textContent = file.name;
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('inputGambarEdit').addEventListener('change', function() {
        var file = this.files[0];
        var label = this.nextElementSibling;
        if (file) label.textContent = file.name;
    });

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var d = this.dataset;
            document.getElementById('editJudul').value = d.judul;
            document.getElementById('editIsi').value = d.isi;
            document.getElementById('editTanggal').value = d.tanggal;
            document.getElementById('editStatus').value = d.status;
            document.getElementById('formEditPengumuman').action = d.updateUrl;

            var gambarContainer = document.getElementById('gambarLamaContainer');
            var gambarPreview = document.getElementById('previewGambarEdit');
            if (d.gambar) {
                gambarContainer.style.display = 'block';
                gambarPreview.src = d.gambar;
            } else {
                gambarContainer.style.display = 'none';
            }

            $('#modalEdit').modal('show');
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('hapusJudul').textContent = '"' + this.dataset.judul + '"';
            document.getElementById('formHapusPengumuman').action = this.dataset.destroyUrl;
            $('#modalHapus').modal('show');
        });
    });

    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').text(fileName || 'Pilih file...');
    });
</script>
@endpush