@extends('layouts.admin')

@section('title', 'Profil Instansi')

@push('styles')
<style>
    .profil-tabs {
        border-bottom: 2px solid #eee0e3;
    }

    .profil-tabs .nav-link {
        color: #7f6267 !important;
        font-weight: 700;
        font-size: .85rem;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 4px;
        margin-right: 26px;
    }

    .profil-tabs .nav-link i {
        margin-right: 6px;
    }

    .profil-tabs .nav-link.active {
        color: #162F55 !important;
        border-bottom-color: #162F55;
        background: transparent;
    }

    .form-group label {
        font-weight: 700;
        font-size: .82rem;
        color: #0B1F3A;
    }

    .form-hint {
        font-size: .75rem;
        color: #9a8a8e;
        margin-top: 4px;
    }

    .sosmed-input-group .input-group-text {
        background: #fff5f7;
        border-color: #ced4da;
        width: 46px;
        justify-content: center;
    }

    .sosmed-input-group.instagram .input-group-text {
        color: #162F55;
    }

    .sosmed-input-group.youtube .input-group-text {
        color: #1E3F70;
    }

    .sosmed-input-group.facebook .input-group-text {
        color: #1565c0;
    }

    .sosmed-input-group.tiktok .input-group-text {
        color: #111827;
    }

    .preview-card {
        border: 1px solid #eee0e3;
        border-radius: .5rem;
        padding: 20px;
        background: #fff5f7;
    }

    .preview-card h6 {
        font-weight: 800;
        color: #162F55;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .preview-logo {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #162F55;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .preview-sosmed a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #eee0e3;
        margin-right: 6px;
        color: #162F55 !important;
    }
</style>
@endpush

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Profil Instansi</h1>
        <div class="text-muted small">Kelola informasi umum, visi misi, dan media sosial Dinas Pendidikan Kabupaten Sumenep.</div>
    </div>
    <button type="submit" form="formProfil" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm text-white">
        <i class="fas fa-save fa-sm text-white"></i> Simpan Perubahan
    </button>
</div>

<form id="formProfil" action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        {{-- FORM PROFIL --}}
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav profil-tabs" id="profilTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-umum-tab" data-toggle="tab" href="#tab-umum" role="tab">
                                <i class="fas fa-info-circle"></i>Umum
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-visimisi-tab" data-toggle="tab" href="#tab-visimisi" role="tab">
                                <i class="fas fa-bullseye"></i>Visi &amp; Misi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-sosmed-tab" data-toggle="tab" href="#tab-sosmed" role="tab">
                                <i class="fas fa-share-alt"></i>Media Sosial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-struktur-tab" data-toggle="tab" href="#tab-struktur" role="tab">
                                <i class="fas fa-sitemap"></i>Struktur Organisasi
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profilTabContent">

                        {{-- TAB UMUM --}}
                        <div class="tab-pane fade show active" id="tab-umum" role="tabpanel">
                            <div class="form-group">
                                <label>Selayang Pandang</label>
                                <textarea class="form-control" rows="5" name="selayang_pandang">{{ old('selayang_pandang', $profil->selayang_pandang) }}</textarea>
                                <div class="form-hint">Ringkasan singkat mengenai profil instansi, ditampilkan di halaman "Tentang Kami" website.</div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="alamat" value="{{ old('alamat', $profil->alamat) }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" name="telepon" value="{{ old('telepon', $profil->telepon) }}">
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $profil->email) }}">
                            </div>
                        </div>

                        {{-- TAB VISI MISI --}}
                        <div class="tab-pane fade" id="tab-visimisi" role="tabpanel">
                            <div class="form-group">
                                <label>Visi</label>
                                <textarea class="form-control" rows="3" name="visi">{{ old('visi', $profil->visi) }}</textarea>
                            </div>
                            <div class="form-group mb-0">
                                <label>Misi</label>
                                <textarea class="form-control" rows="6" name="misi">{{ old('misi', $profil->misi) }}</textarea>
                                <div class="form-hint">Gunakan penomoran (1. 2. 3. dst) untuk setiap poin misi, satu poin per baris.</div>
                            </div>
                        </div>

                        {{-- TAB MEDIA SOSIAL --}}
                        <div class="tab-pane fade" id="tab-sosmed" role="tabpanel">
                            <div class="form-group">
                                <label>Instagram</label>
                                <div class="input-group sosmed-input-group instagram">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram"></i></span></div>
                                    <input type="text" class="form-control" name="instagram" value="{{ old('instagram', $profil->instagram) }}" placeholder="https://instagram.com/...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>YouTube</label>
                                <div class="input-group sosmed-input-group youtube">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-youtube"></i></span></div>
                                    <input type="text" class="form-control" name="youtube" value="{{ old('youtube', $profil->youtube) }}" placeholder="https://youtube.com/@...">
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Facebook</label>
                                <div class="input-group sosmed-input-group facebook">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook-f"></i></span></div>
                                    <input type="text" class="form-control" name="facebook" value="{{ old('facebook', $profil->facebook) }}" placeholder="https://facebook.com/...">
                                </div>
                            </div>
                            <div class="form-group mb-0 mt-3">
                                <label>TikTok</label>
                                <div class="input-group sosmed-input-group tiktok">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-tiktok"></i></span></div>
                                    <input type="text" class="form-control" name="tiktok" value="{{ old('tiktok', $profil->tiktok) }}" placeholder="https://tiktok.com/@...">
                                </div>
                            </div>
                        </div>
                        {{-- TAB STRUKTUR ORGANISASI --}}
                        <div class="tab-pane fade" id="tab-struktur" role="tabpanel">
                            <div class="form-group">
                                <label>Gambar Bagan Struktur Organisasi</label>

                                <div class="mb-3" id="struktur-preview-wrap" style="{{ $profil->struktur_organisasi ? '' : 'display:none;' }}">
                                    <img id="struktur-preview" src="{{ $profil->struktur_organisasi ? Storage::url($profil->struktur_organisasi) : '' }}"
                                        alt="Struktur Organisasi" style="max-width:100%; border-radius:8px; border:1px solid #eee0e3;">
                                </div>

                                <div id="struktur-empty-msg" class="alert alert-warning py-2 small mb-3" style="{{ $profil->struktur_organisasi ? 'display:none;' : '' }}">
                                    Belum ada gambar struktur organisasi yang diunggah.
                                </div>

                                <input type="file" class="form-control-file" id="struktur-input" name="struktur_organisasi" accept="image/png, image/jpeg, image/webp">
                                <div class="form-hint">Unggah gambar bagan struktur organisasi (JPG/PNG/WEBP, maks. 4MB). Gambar ini akan tampil di halaman publik "Struktur Organisasi".</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PREVIEW --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Pratinjau Tampilan Publik</h6>
                </div>
                <div class="card-body">
                    <div class="preview-card text-center mb-3">
                        <div class="preview-logo mx-auto"><i class="fas fa-graduation-cap"></i></div>
                        <div class="font-weight-bold" style="color:#4d1e2a;">Dinas Pendidikan Kabupaten Sumenep</div>
                        <div class="small text-muted">{{ $profil->email ?: '-' }}</div>
                    </div>
                    <h6>Alamat</h6>
                    <p class="small mb-3">{{ $profil->alamat ?: '-' }}</p>
                    <h6>Telepon</h6>
                    <p class="small mb-3">{{ $profil->telepon ?: '-' }}</p>
                    <h6>Media Sosial</h6>
                    <div class="preview-sosmed mb-2">
                        @if ($profil->instagram)
                        <a href="{{ $profil->instagram }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if ($profil->youtube)
                        <a href="{{ $profil->youtube }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if ($profil->facebook)
                        <a href="{{ $profil->facebook }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($profil->tiktok)
                        <a href="{{ $profil->tiktok }}" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        @endif
                        @if (!$profil->instagram && !$profil->youtube && !$profil->facebook && !$profil->tiktok)
                        <span class="text-muted small">Belum ada media sosial</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Terakhir Diperbarui</div>
                    <div class="small text-muted">
                        <i class="fas fa-clock mr-1"></i>
                        @if ($profil->updated_at)
                        {{ $profil->updated_at->format('d M Y, H:i') }} oleh {{ auth()->user()->name }}
                        @else
                        Belum pernah diperbarui
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" form="formProfil" class="btn btn-primary btn-block d-sm-none">
                <i class="fas fa-save mr-1"></i>Simpan Perubahan
            </button>
        </div>

    </div>
</form>



@endsection

@push('scripts')
<script>
    document.getElementById('struktur-input').addEventListener('change', function() {
        var file = this.files[0];
        var previewWrap = document.getElementById('struktur-preview-wrap');
        var preview = document.getElementById('struktur-preview');
        var emptyMsg = document.getElementById('struktur-empty-msg');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewWrap.style.display = 'block';
                emptyMsg.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush