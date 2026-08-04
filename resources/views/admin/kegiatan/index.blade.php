@extends('layouts.admin')

@section('title', 'Kegiatan')

@push('styles')
<style>
    #tambahKegiatanModal .modal-header, #editKegiatanModal .modal-header { background-color:#162F55; color:#fff; }
    #tambahKegiatanModal .modal-header .close, #editKegiatanModal .modal-header .close { color:#fff; opacity:.85; text-shadow:none; }
    .filter-bar { background:#f0f4fa; border:1px solid #d0daea; border-radius:8px; padding:14px 18px; margin-bottom:18px; }
    .filter-bar label { font-size:.78rem; font-weight:700; color:#0B1F3A; margin-bottom:4px; }
    .filter-bar .form-control { font-size:.85rem; border-color:#b8c8df; }
    .jumlah-hasil { font-size:.82rem; color:#6B7280; }
    .kegiatan-thumb { width:70px; height:48px; object-fit:cover; border-radius:4px; }
    .badge-berlangsung { display:inline-block; padding:3px 9px; border-radius:20px; background:#e6f7ec; color:#1a7d3a; font-size:.7rem; font-weight:700; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kegiatan &mdash; {{ $bidang->nama }}</h1>
            <div class="text-muted small">Kelola kegiatan Dinas Pendidikan Kabupaten Sumenep.</div>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white" data-toggle="modal" data-target="#tambahKegiatanModal">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Kegiatan
        </a>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Kegiatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKegiatan }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar-check fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Terbit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTerbit }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Draft</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDraft }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left:4px solid #162F55;">
            <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-calendar-check mr-2" style="color:#162F55;"></i>Daftar Kegiatan</h6>
        </div>
        <div class="card-body">

            <div class="filter-bar">
                <form method="GET" id="formFilter">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-2 mb-md-0">
                            <label><i class="fas fa-toggle-on mr-1"></i>Status</label>
                            <select name="status" class="form-control" onchange="this.form.submit();">
                                <option value="">-- Semua Status --</option>
                                <option value="terbit" {{ $filterStatus === 'terbit' ? 'selected' : '' }}>Terbit</option>
                                <option value="draf" {{ $filterStatus === 'draf' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.kegiatan.per-bidang', $bidang) }}" class="btn btn-outline-secondary btn-block" style="border-color:#b8c8df; color:#0B1F3A;">
                                <i class="fas fa-times mr-1"></i>Reset filter
                            </a>
                        </div>
                    </div>
                </form>
                <div class="mt-3">
                    <span class="jumlah-hasil">
                        Menampilkan <strong>{{ $kegiatan->count() }}</strong> dari <strong>{{ $kegiatan->total() }}</strong> kegiatan
                        &middot; Halaman {{ $kegiatan->currentPage() }} dari {{ $kegiatan->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr><th>Gambar</th><th>Judul Kegiatan</th><th>Bidang</th><th>Periode Pelaksanaan</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatan as $k)
                            @php
                                $hariIni = now()->toDateString();
                                $mulai = $k->tanggal_mulai->toDateString();
                                $selesai = ($k->tanggal_selesai ?? $k->tanggal_mulai)->toDateString();
                                $sedangBerlangsung = $hariIni >= $mulai && $hariIni <= $selesai;
                            @endphp
                            <tr>
                                <td><img class="kegiatan-thumb" src="{{ $k->gambar ? Storage::url($k->gambar) : asset('admin-assets/img/undraw_posting_photo.svg') }}"></td>
                                <td>
                                    {{ $k->judul }}
                                    @if ($sedangBerlangsung)
                                        <div class="mt-1"><span class="badge-berlangsung"><i class="fas fa-circle fa-xs mr-1"></i>Sedang Berlangsung</span></div>
                                    @endif
                                </td>
                                <td>{{ $k->bidang->nama ?? '-' }}</td>
                                <td>{{ $k->tanggal_mulai->translatedFormat('d F Y') }} &ndash; {{ $k->tanggal_selesai?->translatedFormat('d F Y') ?? '-' }}</td>
                                <td>
                                    @if ($k->status === 'terbit')
                                        <span class="badge badge-success">Terbit</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex" style="gap:6px;">
                                        <button type="button" class="btn btn-sm btn-primary" title="Edit"
                                            onclick="openEditKegiatan(this)"
                                            data-bidang="{{ $k->bidang_id }}"
                                            data-judul="{{ $k->judul }}"
                                            data-mulai="{{ $k->tanggal_mulai->format('Y-m-d') }}"
                                            data-selesai="{{ $k->tanggal_selesai?->format('Y-m-d') }}"
                                            data-status="{{ $k->status }}"
                                            data-deskripsi="{{ $k->deskripsi }}"
                                            data-gambar="{{ $k->gambar ? Storage::url($k->gambar) : '' }}"
                                            data-update-url="{{ route('admin.kegiatan.update', $k) }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-hapus ml-1"
                                            data-judul="{{ $k->judul }}"
                                            data-destroy-url="{{ route('admin.kegiatan.destroy', $k) }}"
                                            title="Hapus" style="padding:4px 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada kegiatan. Klik "Tambah Kegiatan" untuk menambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $kegiatan->links() }}</div>

        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="tambahKegiatanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold small">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Bidang</label>
                                <select class="form-control" name="bidang_id" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($bidangList as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar</label>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Status</label>
                            <select class="form-control" name="status">
                                <option value="draf">Simpan sebagai Draft</option>
                                <option value="terbit">Terbitkan Sekarang</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" rows="4" required></textarea>
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
    <div class="modal fade" id="editKegiatanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kegiatan</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditKegiatan" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold small">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="judul" id="edit-judul" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Bidang</label>
                                <select class="form-control" name="bidang_id" id="edit-bidang" required>
                                    @foreach ($bidangList as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="edit-mulai" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="edit-selesai" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar</label>
                            <div class="d-flex align-items-center mb-2" style="gap:12px;">
                                <img id="edit-gambar-preview" src="{{ asset('admin-assets/img/undraw_posting_photo.svg') }}"
                                    style="width:70px;height:48px;object-fit:cover;border-radius:4px;border:1px solid #eee0e3;">
                                <small class="text-muted">Gambar saat ini. Unggah file baru untuk menggantinya.</small>
                            </div>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Status</label>
                            <select class="form-control" name="status" id="edit-status">
                                <option value="draf">Simpan sebagai Draft</option>
                                <option value="terbit">Terbitkan Sekarang</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi" id="edit-deskripsi" rows="4" required></textarea>
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
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Kegiatan</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus kegiatan:</p>
                    <p class="font-weight-bold" id="hapusJudul"></p>
                </div>
                <div class="modal-footer">
                    <form id="formHapusKegiatan" method="POST">
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
function openEditKegiatan(btn) {
    var d = btn.dataset;
    document.getElementById('edit-bidang').value = d.bidang;
    document.getElementById('edit-judul').value = d.judul;
    document.getElementById('edit-mulai').value = d.mulai;
    document.getElementById('edit-selesai').value = d.selesai;
    document.getElementById('edit-status').value = d.status;
    document.getElementById('edit-deskripsi').value = d.deskripsi || '';
    document.getElementById('edit-gambar-preview').src = d.gambar || "{{ asset('admin-assets/img/undraw_posting_photo.svg') }}";
    document.getElementById('formEditKegiatan').action = d.updateUrl;
    $('#editKegiatanModal').modal('show');
}

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusJudul').textContent = this.dataset.judul;
        document.getElementById('formHapusKegiatan').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush