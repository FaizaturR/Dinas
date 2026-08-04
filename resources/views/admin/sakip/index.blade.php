@extends('layouts.admin')

@section('title', 'SAKIP')

@push('styles')
<style>
    #tambahSakipModal .modal-header, #editSakipModal .modal-header { background-color:#162F55; color:#fff; }
    #tambahSakipModal .modal-header .close, #editSakipModal .modal-header .close { color:#fff; opacity:.85; text-shadow:none; }
    .filter-bar { background:#f0f4fa; border:1px solid #d0daea; border-radius:8px; padding:14px 18px; margin-bottom:18px; }
    .filter-bar label { font-size:.78rem; font-weight:700; color:#0B1F3A; margin-bottom:4px; }
    .filter-bar .form-control { font-size:.85rem; border-color:#b8c8df; }
    .jumlah-hasil { font-size:.82rem; color:#6B7280; }
    .btn-unduh { display:inline-flex; align-items:center; gap:6px; color:#162F55; font-weight:600; font-size:.85rem; }
    .file-icon-pdf { color:#e74a3b; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">SAKIP</h1>
            <div class="text-muted small">Sistem Akuntabilitas Kinerja Instansi Pemerintah &mdash; arsip dokumen Renstra &amp; Perjanjian Kinerja, LKjIP, dan IKU.</div>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white" data-toggle="modal" data-target="#tambahSakipModal">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Dokumen
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Dokumen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDokumen }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-folder-open fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Renstra &amp; PK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRenstra }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-signature fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">LKjIP</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLkjip }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-chart-line fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">IKU</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalIku }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-bullseye fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left:4px solid #162F55;">
            <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-file-contract mr-2" style="color:#162F55;"></i>Arsip Dokumen SAKIP</h6>
        </div>
        <div class="card-body">

            <div class="filter-bar">
                <form method="GET" id="formFilter">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label><i class="fas fa-tags mr-1"></i>Kategori</label>
                            <select name="kategori" class="form-control" onchange="this.form.submit();">
                                <option value="">-- Semua kategori --</option>
                                @foreach ($kategoriLabel as $key => $l)
                                    <option value="{{ $key }}" {{ $filterKategori === $key ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label><i class="fas fa-calendar-alt mr-1"></i>Tahun</label>
                            <select name="tahun" class="form-control" onchange="this.form.submit();">
                                <option value="">-- Semua tahun --</option>
                                @foreach ($daftarTahun as $th)
                                    <option value="{{ $th }}" {{ (string) $filterTahun === (string) $th ? 'selected' : '' }}>{{ $th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.sakip.index') }}" class="btn btn-outline-secondary btn-block" style="border-color:#b8c8df; color:#0B1F3A;">
                                <i class="fas fa-times mr-1"></i>Reset filter
                            </a>
                        </div>
                    </div>
                </form>
                <div class="mt-3">
                    <span class="jumlah-hasil">
                        Menampilkan <strong>{{ $sakip->count() }}</strong> dari <strong>{{ $sakip->total() }}</strong> dokumen
                        &middot; Halaman {{ $sakip->currentPage() }} dari {{ $sakip->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr><th>Kategori</th><th>Judul Dokumen</th><th>Tahun</th><th>File</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($sakip as $s)
                            <tr>
                                <td><span class="badge {{ $kategoriBadge[$s->kategori] ?? 'badge-secondary' }}">{{ $kategoriLabel[$s->kategori] ?? $s->kategori }}</span></td>
                                <td>
                                    {{ $s->judul }}
                                    @if ($s->keterangan)
                                        <div class="text-muted small">{{ $s->keterangan }}</div>
                                    @endif
                                </td>
                                <td>{{ $s->tahun }}</td>
                                <td>
                                    <a class="btn-unduh" href="{{ Storage::url($s->file) }}" target="_blank">
                                        <i class="fas fa-file-pdf file-icon-pdf"></i> Unduh PDF
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center" style="gap:6px;">
                                        <button type="button" class="btn btn-sm btn-primary" title="Edit"
                                            onclick="openEditSakip(this)"
                                            data-kategori="{{ $s->kategori }}"
                                            data-judul="{{ $s->judul }}"
                                            data-tahun="{{ $s->tahun }}"
                                            data-keterangan="{{ $s->keterangan }}"
                                            data-file="{{ basename($s->file) }}"
                                            data-update-url="{{ route('admin.sakip.update', $s) }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-hapus ml-1"
                                            data-judul="{{ $s->judul }}"
                                            data-destroy-url="{{ route('admin.sakip.destroy', $s) }}"
                                            title="Hapus" style="padding:4px 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada dokumen SAKIP. Klik "Tambah Dokumen" untuk menambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $sakip->links() }}</div>

        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="tambahSakipModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Dokumen SAKIP</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.sakip.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Kategori</label>
                            <select class="form-control" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriLabel as $key => $l)
                                    <option value="{{ $key }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul Dokumen</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tahun</label>
                            <input type="number" class="form-control" name="tahun" min="2000" max="2100" value="{{ now()->year }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">File PDF</label>
                            <input type="file" class="form-control-file" name="file" accept="application/pdf" required>
                            <small class="form-text text-muted">Hanya file PDF, maks. 5MB.</small>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="editSakipModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Dokumen SAKIP</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditSakip" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Kategori</label>
                            <select class="form-control" name="kategori" id="edit-kategori" required>
                                @foreach ($kategoriLabel as $key => $l)
                                    <option value="{{ $key }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul Dokumen</label>
                            <input type="text" class="form-control" name="judul" id="edit-judul" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tahun</label>
                            <input type="number" class="form-control" name="tahun" id="edit-tahun" min="2000" max="2100" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">File PDF</label>
                            <div class="mb-2 small text-muted">File saat ini: <span id="edit-file-current" class="font-weight-bold"></span></div>
                            <input type="file" class="form-control-file" name="file" accept="application/pdf">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="edit-keterangan" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Perbarui</button>
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
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Sakip</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus sakip:</p>
                    <p class="font-weight-bold" id="hapusJudul"></p>
                </div>
                <div class="modal-footer">
                    <form id="formHapusSakip" method="POST">
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
<script>
function openEditSakip(btn) {
    var d = btn.dataset;
    document.getElementById('edit-kategori').value = d.kategori;
    document.getElementById('edit-judul').value = d.judul;
    document.getElementById('edit-tahun').value = d.tahun;
    document.getElementById('edit-keterangan').value = d.keterangan || '';
    document.getElementById('edit-file-current').textContent = d.file || '(tidak ada)';
    document.getElementById('formEditSakip').action = d.updateUrl;
    $('#editSakipModal').modal('show');
}

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusJudul').textContent = '"' + this.dataset.judul + '"';
        document.getElementById('formHapusSakip').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush