@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    #tambahBeritaModal .modal-header { background-color:#162F55; color:#fff; }
    #tambahBeritaModal .modal-header .close { color:#fff; opacity:.85; text-shadow:none; }
    .badge-terbit { background:#d4edda; color:#155724; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:500; }
    .badge-draf { background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:500; }
    .berita-thumb { width:80px; height:55px; object-fit:cover; border-radius:4px; }
    .filter-periode-card .form-inline .form-control { min-width:150px; }
    .filter-periode-label { font-size:.7rem; font-weight:800; letter-spacing:.4px; text-transform:uppercase; color:#6B7280; margin-bottom:4px; }
    .filter-mode-badge { display:inline-block; padding:4px 10px; border-radius:20px; background:#F7F4EE; border:1px solid #E5E1D8; font-size:.72rem; font-weight:700; color:#162F55; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
            <div class="text-muted small">Kelola artikel berita yang tampil di website Dinas Pendidikan Kabupaten Sumenep</div>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white" data-toggle="modal" data-target="#tambahBeritaModal">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Berita
        </a>
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
                        <div class="mt-1"><a href="{{ route('admin.berita.index') }}" class="small">&larr; Reset ke Semua Waktu</a></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">TOTAL BERITA</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBerita }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">DIPUBLIKASIKAN</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $beritaTerbit }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">DRAFT</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $beritaDraft }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Daftar Berita</h6>
            <span class="small text-muted">{{ $filterMode === 'semua' ? '5 berita terbaru' : ('Periode: ' . $labelPeriode) }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                    </thead>
                    <tfoot>
                        <tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                    </tfoot>
                    <tbody>
                        @forelse ($berita as $b)
                            <tr>
                                <td>
                                    <img class="berita-thumb" src="{{ $b->gambar ? Storage::url($b->gambar) : asset('admin-assets/img/undraw_posting_photo.svg') }}">
                                </td>
                                <td>
                                    {{ $b->judul }}
                                    <p class="mb-0">
                                        <a href="{{ route('berita.show', $b->slug) }}"
                                           target="_blank"
                                           style="color: #0066cc !important; text-decoration: underline !important;">
                                            Baca Selengkapnya
                                        </a>
                                    </p>
                                </td>
                                <td>{{ $b->kategori->nama ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    @if ($b->status === 'terbit')
                                        <span class="badge badge-terbit">Dipublikasikan</span>
                                    @else
                                        <span class="badge badge-draf">Draft</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center small text-muted">
                                    {{ ($b->tanggal_publish ?? $b->created_at)->format('d M Y') }}
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center" style="gap:6px;">
                                        <button type="button" class="btn btn-sm btn-primary" title="Edit"
                                            onclick="openEditBerita(this)"
                                            data-judul="{{ $b->judul }}"
                                            data-kategori="{{ $b->kategori_id }}"
                                            data-status="{{ $b->status }}"
                                            data-tanggal="{{ $b->tanggal_publish?->format('Y-m-d') }}"
                                            data-gambar="{{ $b->gambar ? Storage::url($b->gambar) : '' }}"
                                            data-update-url="{{ route('admin.berita.update', $b) }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-hapus ml-1"
                                            data-judul="{{ $b->judul }}"
                                            data-destroy-url="{{ route('admin.berita.destroy', $b) }}"
                                            title="Hapus" style="padding:4px 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <textarea id="isi-data-{{ $b->id }}" style="display:none;">{{ $b->isi }}</textarea>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Belum ada berita. Klik "Tambah Berita" untuk menambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="tambahBeritaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul Berita</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small d-flex justify-content-between align-items-center">
                                    Kategori
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:11px;"
                                        onclick="bukaTambahKategori('tambah')">
                                        <i class="fas fa-plus"></i> Kategori Baru
                                    </button>
                                </label>
                                <select class="form-control" name="kategori_id" id="kategori-tambah">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($kategoriList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Tanggal Publish</label>
                                <input type="date" class="form-control" name="tanggal_publish" value="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Status</label>
                                <select class="form-control" name="status">
                                    <option value="draf">Simpan sebagai Draft</option>
                                    <option value="terbit">Terbitkan Sekarang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar Sampul</label>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp">
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Isi Berita</label>
                            <textarea class="form-control" name="isi" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="editBeritaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header btn-primary">
                    <h5 class="modal-title" style="color:#fff;">Edit Berita</h5>
                    <button class="close" type="button" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
                </div>
                <form id="formEditBerita" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul Berita</label>
                            <input type="text" class="form-control" name="judul" id="edit-judul" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small d-flex justify-content-between align-items-center">
                                    Kategori
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:11px;"
                                        onclick="bukaTambahKategori('edit')">
                                        <i class="fas fa-plus"></i> Kategori Baru
                                    </button>
                                </label>
                                <select class="form-control" name="kategori_id" id="edit-kategori">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($kategoriList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Tanggal Publish</label>
                                <input type="date" class="form-control" name="tanggal_publish" id="edit-tanggal">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">Status</label>
                                <select class="form-control" name="status" id="edit-status">
                                    <option value="draf">Simpan sebagai Draft</option>
                                    <option value="terbit">Terbitkan Sekarang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar Sampul</label>
                            <div class="d-flex align-items-center mb-2" style="gap:12px;">
                                <img id="edit-gambar-preview" src="{{ asset('admin-assets/img/undraw_posting_photo.svg') }}"
                                    style="width:70px;height:48px;object-fit:cover;border-radius:4px;border:1px solid #eee0e3;">
                                <small class="text-muted">Gambar saat ini. Unggah file baru untuk menggantinya.</small>
                            </div>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp">
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Isi Berita</label>
                            <textarea class="form-control" name="isi" id="edit-isi" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Perbarui Berita</button>
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
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Berita</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus berita:</p>
                    <p class="font-weight-bold" id="hapusJudul"></p>
                </div>
                <div class="modal-footer">
                    <form id="formHapusBerita" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i>Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KATEGORI (AJAX) --}}
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="kategoriError" class="alert alert-danger py-2 small d-none"></div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small">Nama Kategori</label>
                        <input type="text" class="form-control" id="kategoriBaruNama" placeholder="Contoh: Prestasi Siswa">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="btnSimpanKategori" onclick="simpanKategoriBaru()">
                        <i class="fas fa-save mr-1"></i> Simpan Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('admin-assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function () { $('#dataTable').DataTable(); });

function openEditBerita(btn) {
    var d = btn.dataset;
    document.getElementById('edit-judul').value = d.judul;
    document.getElementById('edit-kategori').value = d.kategori || '';
    document.getElementById('edit-status').value = d.status;
    document.getElementById('edit-tanggal').value = d.tanggal || '';
    document.getElementById('edit-isi').value = document.getElementById('isi-data-' + btn.closest('tr').querySelector('textarea').id.split('-').pop()).value;

    // ambil isi dari textarea tersembunyi di baris yang sama
    var isiEl = btn.closest('tr').querySelector('textarea[id^="isi-data-"]');
    document.getElementById('edit-isi').value = isiEl ? isiEl.value : '';

    document.getElementById('edit-gambar-preview').src = d.gambar || "{{ asset('admin-assets/img/undraw_posting_photo.svg') }}";
    document.getElementById('formEditBerita').action = d.updateUrl;

    $('#editBeritaModal').modal('show');
}

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusJudul').textContent = this.dataset.judul;
        document.getElementById('formHapusBerita').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});

var sumberKategoriModal = null;

function bukaTambahKategori(sumber) {
    sumberKategoriModal = sumber;
    document.getElementById('kategoriBaruNama').value = '';
    var errBox = document.getElementById('kategoriError');
    errBox.classList.add('d-none');

    var modalAsalId = (sumber === 'edit') ? '#editBeritaModal' : '#tambahBeritaModal';
    $(modalAsalId).modal('hide');
    $('#tambahKategoriModal').modal('show');
}

function simpanKategoriBaru() {
    var nama = document.getElementById('kategoriBaruNama').value.trim();
    var errBox = document.getElementById('kategoriError');
    var btn = document.getElementById('btnSimpanKategori');

    if (nama === '') {
        errBox.textContent = 'Nama kategori wajib diisi.';
        errBox.classList.remove('d-none');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

    fetch("{{ route('admin.berita.kategori.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: (function () { var fd = new FormData(); fd.append('nama', nama); return fd; })()
    })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Kategori';

            if (!data.success) {
                errBox.textContent = data.message || 'Gagal menyimpan kategori.';
                errBox.classList.remove('d-none');
                return;
            }

            ['kategori-tambah', 'edit-kategori'].forEach(function (selectId) {
                var select = document.getElementById(selectId);
                if (!select) return;
                var opt = document.createElement('option');
                opt.value = data.id;
                opt.textContent = data.nama;
                select.appendChild(opt);
            });

            var selectAsalId = (sumberKategoriModal === 'edit') ? 'edit-kategori' : 'kategori-tambah';
            document.getElementById(selectAsalId).value = data.id;

            $('#tambahKategoriModal').modal('hide');
            var modalAsalId = (sumberKategoriModal === 'edit') ? '#editBeritaModal' : '#tambahBeritaModal';
            $(modalAsalId).modal('show');
        })
        .catch(function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Kategori';
            errBox.textContent = 'Terjadi kesalahan koneksi. Coba lagi.';
            errBox.classList.remove('d-none');
        });
}
</script>
@endpush