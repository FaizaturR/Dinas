@extends('layouts.admin')

@section('title', 'Kelola Admin')

@push('styles')
<link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .admin-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #162F55;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .admin-nama {
        font-weight: 700;
        color: #4d1e2a;
        margin-bottom: 0;
    }

    .admin-email {
        font-size: .8rem;
        color: #9a8a8e;
    }

    #adminModal .modal-header {
        background-color: #162F55;
        color: #fff;
        border-bottom: none;
    }

    #adminModal .modal-header .close {
        color: #fff;
        opacity: .85;
        text-shadow: none;
    }
</style>
@endpush

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Admin</h1>
        <div class="text-muted small">Kelola akun admin yang bisa mengakses panel ini.</div>
    </div>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white"
        data-toggle="modal" data-target="#adminModal" onclick="openAdminModal('tambah')">
        <i class="fas fa-plus fa-sm text-white"></i>&nbsp; Tambah Admin
    </a>
</div>

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Akun Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdmin }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-shield fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Daftar Akun Admin</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width:60px"></th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dibuat</th>
                        <th style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($daftarAdmin as $a)
                    <tr>
                        <td>
                            <div class="admin-avatar">{{ strtoupper(substr(trim($a->name), 0, 1) ?: '?') }}</div>
                        </td>
                        <td>
                            <p class="admin-nama">
                                {{ $a->name }}
                                @if ($a->id === auth()->id())
                                <span class="badge badge-info">Anda</span>
                                @endif
                            </p>
                        </td>
                        <td>
                            <div class="admin-email">{{ $a->email }}</div>
                        </td>
                        <td>{{ $a->created_at?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" title="Edit"
                                onclick="openAdminModal('edit', this)"
                                data-id="{{ $a->id }}"
                                data-nama="{{ $a->name }}"
                                data-email="{{ $a->email }}"
                                data-update-url="{{ route('admin.kelola-admin.update', $a) }}">
                                <i class="fas fa-pen"></i>
                            </button>
                            @if ($a->id !== auth()->id())
                            <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                data-judul="{{ $a->name }}"
                                data-destroy-url="{{ route('admin.kelola-admin.destroy', $a) }}">
                                Hapus
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data admin. Klik "Tambah Admin" untuk menambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH/EDIT --}}
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalLabel">Tambah Admin</h5>
                <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formAdmin" method="POST" action="{{ route('admin.kelola-admin.store') }}">
                @csrf
                <input type="hidden" name="_method" id="ad-method" value="">
                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="ad-nama"
                                placeholder="Contoh: Ahmad Fauzi" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small">Email</label>
                            <input type="email" class="form-control" name="email" id="ad-email"
                                placeholder="admin@disdik.sumenepkab.go.id" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small">Role</label>
                            <select class="form-control" name="role" id="ad-role" required>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small">Password</label>
                            <input type="password" class="form-control" name="password" id="ad-password"
                                placeholder="Minimal 6 karakter" autocomplete="new-password">
                            <small class="text-muted" id="ad-password-help">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold small">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="ad-konfirmasi"
                                placeholder="Ulangi password" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="ad-submit">Simpan Akun Admin</button>
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
                <h5 class="modal-title text-white"><i class="fas fa-trash mr-2"></i>Hapus Admin</h5>
                <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p>Yakin ingin menghapus akun:</p>
                <p class="font-weight-bold" id="hapusJudul"></p>
                <p class="text-muted small">Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <form id="formHapusAdmin" method="POST">
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

    function openAdminModal(mode, btn) {
        var title = document.getElementById('adminModalLabel');
        var submitBtn = document.getElementById('ad-submit');
        var form = document.getElementById('formAdmin');
        var passwordHelp = document.getElementById('ad-password-help');
        var passwordInput = document.getElementById('ad-password');
        var konfirmasiInput = document.getElementById('ad-konfirmasi');

        if (mode === 'tambah') {
            title.textContent = 'Tambah Admin';
            submitBtn.textContent = 'Simpan Akun Admin';
            form.action = "{{ route('admin.kelola-admin.store') }}";
            document.getElementById('ad-method').value = '';
            form.reset();
            passwordHelp.style.display = 'none';
            passwordInput.required = true;
            konfirmasiInput.required = true;
        } else if (mode === 'edit' && btn) {
            var d = btn.dataset;
            title.textContent = 'Edit Akun Admin';
            submitBtn.textContent = 'Perbarui Akun Admin';
            form.action = d.updateUrl;
            document.getElementById('ad-method').value = 'PUT';

            document.getElementById('ad-nama').value = d.nama || '';
            document.getElementById('ad-email').value = d.email || '';
            document.getElementById('ad-role').value = d.role || 'admin';
            passwordInput.value = '';
            konfirmasiInput.value = '';
            passwordHelp.style.display = 'block';
            passwordInput.required = false;
            konfirmasiInput.required = false;

            $('#adminModal').modal('show');
        }
    }

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('hapusJudul').textContent = this.dataset.judul;
            document.getElementById('formHapusAdmin').action = this.dataset.destroyUrl;
            $('#modalHapus').modal('show');
        });
    });
</script>
@if ($errors->any())
<script>
    $(document).ready(function() {
        document.getElementById('ad-nama').value = "{{ old('nama') }}";
        document.getElementById('ad-email').value = "{{ old('email') }}";
        $('#adminModal').modal('show');
    });
</script>
@endif
@endpush