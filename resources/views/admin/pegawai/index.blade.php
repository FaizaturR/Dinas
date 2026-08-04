@extends('layouts.admin')

@section('title', 'Data Pegawai')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .pegawai-avatar { width:42px; height:42px; border-radius:50%; object-fit:cover; border:1px solid #eee0e3; }
    .pegawai-nama { font-weight:700; color:#4d1e2a; margin-bottom:0; }
    .pegawai-nip { font-size:.75rem; color:#9a8a8e; }
    #pegawaiModal .modal-header { background-color:#162F55; color:#fff; border-bottom:none; }
    #pegawaiModal .modal-header .close { color:#fff; opacity:.85; text-shadow:none; }
    .upload-photo-box { border:1.5px dashed #d9c3c9; border-radius:.35rem; padding:14px; text-align:center; cursor:pointer; background:#fff5f7; }
    .upload-photo-box:hover { border-color:#162F55; }
    .upload-photo-preview { width:64px; height:64px; border-radius:50%; object-fit:cover; border:1px solid #eee0e3; }
</style>
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Pegawai</h1>
            <div class="text-muted small">Kelola data pegawai Dinas Pendidikan Kabupaten Sumenep.</div>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white"
            data-toggle="modal" data-target="#pegawaiModal" onclick="openPegawaiModal('tambah')">
            <i class="fas fa-plus fa-sm text-white"></i> Tambah Pegawai
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Pegawai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPegawai }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pegawai Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pegawaiAktif }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Non-Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pegawaiNonaktif }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-slash fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Jumlah Bidang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahBidang }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center" style="gap:10px;">
            <h6 class="m-0 font-weight-bold text-dark">Daftar Pegawai</h6>
            <div class="d-flex align-items-center" style="gap:8px;">
                <label for="filterBidang" class="mb-0 small font-weight-bold text-muted">Filter Bidang:</label>
                <select id="filterBidang" class="form-control form-control-sm" style="width:auto; min-width:190px;">
                    <option value="">-- Semua Bidang --</option>
                    @foreach ($bidang as $b)
                        <option value="{{ $b->nama }}">{{ $b->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width:60px">Foto</th>
                            <th>Nama / NIP</th>
                            <th>Jabatan</th>
                            <th>Bidang</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th style="width:110px">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Foto</th><th>Nama / NIP</th><th>Jabatan</th><th>Bidang</th><th>Email</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($pegawai as $p)
                            <tr>
                                <td><img class="pegawai-avatar" src="{{ $p->foto ? Storage::url($p->foto) : asset('admin-assets/img/profile.webp') }}"></td>
                                <td>
                                    <p class="pegawai-nama">{{ $p->nama }}</p>
                                    <div class="pegawai-nip">NIP. {{ $p->nip ?: '-' }}</div>
                                </td>
                                <td>{{ $p->jabatan }}</td>
                                <td>{{ $p->bidang->nama ?? '-' }}</td>
                                <td>{{ $p->email ?: '-' }}</td>
                                <td>
                                    @if ($p->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit"
                                        onclick="openPegawaiModal('edit', this)"
                                        data-nama="{{ $p->nama }}"
                                        data-nip="{{ $p->nip }}"
                                        data-jabatan="{{ $p->jabatan }}"
                                        data-bidang="{{ $p->bidang_id }}"
                                        data-email="{{ $p->email }}"
                                        data-status="{{ $p->status }}"
                                        data-foto="{{ $p->foto ? Storage::url($p->foto) : asset('admin-assets/img/profile.webp') }}"
                                        data-update-url="{{ route('admin.pegawai.update', $p) }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                        data-judul="{{ $p->nama }}"
                                        data-destroy-url="{{ route('admin.pegawai.destroy', $p) }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pegawai. Klik "Tambah Pegawai" untuk menambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH/EDIT --}}
    <div class="modal fade" id="pegawaiModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pegawaiModalLabel">Tambah Pegawai</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formPegawai" method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="pg-method" value="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold small">Nama Lengkap &amp; Gelar</label>
                                <input type="text" class="form-control" name="nama" id="pg-nama"
                                    placeholder="Contoh: Nurul Hidayati, S.Pd." required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold small">NIP</label>
                                <input type="text" class="form-control" name="nip" id="pg-nip">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="pg-jabatan" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Bidang</label>
                                <select class="form-control" name="bidang_id" id="pg-bidang">
                                    <option value="">- Tanpa bidang -</option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Email</label>
                                <input type="email" class="form-control" name="email" id="pg-email">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Status Kepegawaian</label>
                                <select class="form-control" name="status" id="pg-status">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Foto Pegawai</label>
                            <div class="d-flex align-items-center" style="gap:16px;">
                                <img id="pg-photo-preview" class="upload-photo-preview" src="{{ asset('admin-assets/img/profile.webp') }}">
                                <div class="upload-photo-box flex-fill" onclick="document.getElementById('pg-foto-input').click()">
                                    <i class="fas fa-camera mr-1"></i> Klik untuk pilih foto — JPG/PNG/WEBP, maks. 2MB
                                </div>
                                <input type="file" name="foto" id="pg-foto-input" accept="image/png, image/jpeg, image/webp" style="display:none;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" id="pg-submit">Simpan Data Pegawai</button>
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
                    <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Pegawai</h5>
                    <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>Yakin ingin menghapus:</p>
                    <p class="font-weight-bold" id="hapusJudul"></p>
                </div>
                <div class="modal-footer">
                    <form id="formHapus" method="POST">
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
function openPegawaiModal(mode, btn) {
    var title = document.getElementById('pegawaiModalLabel');
    var submitBtn = document.getElementById('pg-submit');
    var form = document.getElementById('formPegawai');

    if (mode === 'tambah') {
        title.textContent = 'Tambah Pegawai';
        submitBtn.textContent = 'Simpan Data Pegawai';
        form.action = "{{ route('admin.pegawai.store') }}";
        document.getElementById('pg-method').value = '';
        form.reset();
        document.getElementById('pg-photo-preview').src = "{{ asset('admin-assets/img/profile.webp') }}";
    } else if (mode === 'edit' && btn) {
        var d = btn.dataset;
        title.textContent = 'Edit Data Pegawai';
        submitBtn.textContent = 'Perbarui Data Pegawai';
        form.action = d.updateUrl;
        document.getElementById('pg-method').value = 'PUT';

        document.getElementById('pg-nama').value = d.nama || '';
        document.getElementById('pg-nip').value = d.nip || '';
        document.getElementById('pg-jabatan').value = d.jabatan || '';
        document.getElementById('pg-bidang').value = d.bidang || '';
        document.getElementById('pg-email').value = d.email || '';
        document.getElementById('pg-status').value = d.status || 'aktif';
        document.getElementById('pg-photo-preview').src = d.foto || "{{ asset('admin-assets/img/profile.webp') }}";

        $('#pegawaiModal').modal('show');
    }
}

document.getElementById('pg-foto-input').addEventListener('change', function () {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('pg-photo-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.querySelectorAll('.btn-hapus').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('hapusJudul').textContent = this.dataset.judul;
        document.getElementById('formHapus').action = this.dataset.destroyUrl;
        $('#modalHapus').modal('show');
    });
});

$(document).ready(function () {
    var table = $('#dataTable').DataTable();

    $('#filterBidang').on('change', function () {
        var nilai = this.value;
        if (nilai === '') {
            table.column(3).search('').draw();
        } else {
            var regex = '^' + $.fn.dataTable.util.escapeRegex(nilai) + '$';
            table.column(3).search(regex, true, false).draw();
        }
    });
});
</script>
@endpush