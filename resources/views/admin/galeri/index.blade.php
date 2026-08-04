@extends('layouts.admin')

@section('title', 'Galeri ' . $label)

@push('styles')
<style>
    #tambahGaleriModal .modal-header, #editGaleriModal .modal-header { background-color:#162F55; color:#fff; }
    #tambahGaleriModal .modal-header .close, #editGaleriModal .modal-header .close { color:#fff; opacity:.85; text-shadow:none; }
    .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px; margin-bottom:8px; }
    .gallery-item { border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.1); transition:transform .3s ease; background:#fff; }
    .gallery-item:hover { transform:translateY(-5px); box-shadow:0 4px 12px rgba(0,0,0,.15); }
    .gallery-item img { width:100%; height:220px; object-fit:cover; display:block; }
    .gallery-item-info { padding:12px; }
    .gallery-item-title { font-weight:700; margin-bottom:2px; }
    .gallery-item-date { font-size:.78rem; color:#9a8a8e; margin-bottom:6px; }
    .gallery-item-keterangan { font-size:.82rem; color:#4d1e2a; margin-bottom:10px; }
    .gallery-item-actions { display:flex; gap:6px; }
    .badge-filter { display:inline-flex; align-items:center; gap:6px; background:#F7F4EE; border:1px solid #E5E1D8; padding:4px 10px; border-radius:20px; font-size:.75rem; font-weight:700; color:#162F55; }
    .badge-filter a { color:#162F55; margin-left:4px; }
    .jumlah-hasil { font-size:.8rem; color:#6B7280; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kelola Galeri &mdash; {{ $label }}</h1>
            <div class="text-muted small">Kelola gambar-gambar yang tampil di halaman galeri website Dinas Pendidikan Kabupaten Sumenep</div>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white"
            data-toggle="modal" data-target="#tambahGaleriModal">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah {{ $label }}
        </a>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total {{ $label }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalItem }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-images fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Ditambahkan Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $itemBulanIni }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar-alt fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left:4px solid #162F55;">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-th-large mr-2" style="color:#162F55;"></i>{{ $label }} Kegiatan
            </h6>
        </div>
        <div class="card-body">

            <div class="filter-bar">
                <form method="GET" id="formFilter">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label><i class="fas fa-search mr-1"></i>Cari judul {{ strtolower($label) }}</label>
                            <input type="text" id="gallerySearch" class="form-control" placeholder="Ketik judul atau tanggal...">
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label><i class="fas fa-calendar-alt mr-1"></i>Filter per bulan</label>
                            <select name="bulan" class="form-control" onchange="this.form.submit();">
                                <option value="">-- Semua bulan --</option>
                                @foreach ($bulanTersedia as $b)
                                    <option value="{{ $b->bulan_key }}" {{ $filterBulan === $b->bulan_key ? 'selected' : '' }}>
                                        {{ $b->bulan_label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-block" style="border-color:#b8c8df; color:#0B1F3A;">
                                <i class="fas fa-times mr-1"></i>Reset filter
                            </a>
                        </div>
                    </div>
                </form>

                <div class="d-flex align-items-center mt-3" style="gap:10px; flex-wrap:wrap;">
                    <span class="jumlah-hasil">
                        Menampilkan <strong>{{ $galeri->count() }}</strong> dari <strong>{{ $galeri->total() }}</strong> {{ strtolower($label) }}
                        &middot; Halaman {{ $galeri->currentPage() }} dari {{ $galeri->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="gallery-grid" id="galleryGrid">
                @forelse ($galeri as $g)
                    <div class="gallery-item" data-title="{{ strtolower($g->judul) }}" data-date="{{ strtolower($g->tanggal->format('d F Y')) }}">
                        <img src="{{ Storage::url($g->gambar) }}" alt="{{ $g->judul }}">
                        <div class="gallery-item-info">
                            <p class="gallery-item-title">{{ $g->judul }}</p>
                            <p class="gallery-item-date">{{ $g->tanggal->format('d F Y') }}</p>
                            @if ($g->keterangan)
                                <p class="gallery-item-keterangan">{{ $g->keterangan }}</p>
                            @endif
                            <div class="gallery-item-actions">
                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="openEditGaleri(this)"
                                    data-judul="{{ $g->judul }}"
                                    data-tanggal="{{ $g->tanggal->format('Y-m-d') }}"
                                    data-keterangan="{{ $g->keterangan }}"
                                    data-gambar="{{ Storage::url($g->gambar) }}"
                                    data-update-url="{{ route('admin.galeri.update', $g) }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                    data-judul="{{ $g->judul }}"
                                    data-destroy-url="{{ route('admin.galeri.destroy', $g) }}">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1;" class="text-center text-muted py-5">
                        <i class="fas fa-images fa-3x mb-3 d-block text-gray-300"></i>
                        Belum ada {{ strtolower($label) }} di galeri. Klik <strong>Tambah {{ $label }}</strong> untuk menambahkan.
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $galeri->links() }}
            </div>

        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="tambahGaleriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah {{ $label }}</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar</label>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp" required>
                            <small class="form-text text-muted">Format JPG/PNG/WEBP, maks. 2MB.</small>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3"></textarea>
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
    <div class="modal fade" id="editGaleriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $label }}</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditGaleri" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Judul</label>
                            <input type="text" class="form-control" name="judul" id="edit-judul" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit-tanggal" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Gambar</label>
                            <div class="d-flex align-items-center mb-2" style="gap:12px;">
                                <img id="edit-gambar-preview" src="" style="width:70px;height:48px;object-fit:cover;border-radius:4px;border:1px solid #eee0e3;">
                                <small class="text-muted">Gambar saat ini. Unggah file baru untuk menggantinya.</small>
                            </div>
                            <input type="file" class="form-control-file" name="gambar" accept="image/png, image/jpeg, image/webp">
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="edit-keterangan" rows="3"></textarea>
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
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus {{ $label }}</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus:</p>
                    <p class="font-weight-bold" id="hapusJudul"></p>
                </div>
                <div class="modal-footer">
                    <form id="formHapusGaleri" method="POST">
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
document.getElementById('gallerySearch').addEventListener('keyup', function () {
    var term = this.value.toLowerCase();
    document.querySelectorAll('.gallery-item').forEach(function (item) {
        var title = item.getAttribute('data-title') || '';
        var date = item.getAttribute('data-date') || '';
        item.style.display = (title.includes(term) || date.includes(term)) ? '' : 'none';
    });
});

function openEditGaleri(btn) {
    var d = btn.dataset;
    document.getElementById('edit-judul').value = d.judul;
    document.getElementById('edit-tanggal').value = d.tanggal;
    document.getElementById('edit-keterangan').value = d.keterangan || '';
    document.getElementById('edit-gambar-preview').src = d.gambar || '';
    document.getElementById('formEditGaleri').action = d.updateUrl;
    $('#editGaleriModal').modal('show');
}

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusJudul').textContent = this.dataset.judul;
        document.getElementById('formHapusGaleri').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush