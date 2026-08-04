@extends('layouts.public')

@section('title', 'Beranda - Dinas Pendidikan Kabupaten Sumenep')

@section('content')

<!-- ===== HERO ===== -->
<section class="hero">
  <div class="hero-bg-slider">
    <div class="hero-bg-slide" style="background-image:url('{{ asset('user-assets/image/bg1.jpg') }}')"></div>
    <div class="hero-bg-slide" style="background-image:url('{{ asset('user-assets/image/bg2.png') }}')"></div>
    <div class="hero-bg-slide" style="background-image:url('{{ asset('user-assets/image/bg3.jpg') }}')"></div>
  </div>
  <div class="hero-pattern"></div>
  <div class="hero-grid"></div>
  <div class="hero-inner">
    <div>
      <div class="hero-badge">Portal Resmi Dinas Pendidikan</div>
      <h2>Selamat Datang Di Dinas Pendidikan Kabupaten Sumenep</h2>
      <p>Mewujudkan layanan pendidikan yang merata, bermutu, dan berkarakter demi generasi Sumenep yang unggul dan berdaya saing.</p>
    </div>
  </div>
</section>

<!-- ===== TICKER ===== -->
<div class="ticker">
  <div class="ticker-inner">
    <span>Dinas Pendidikan Sumenep</span>
    <span>Bismillah Melayani</span>
    <span>Dinas Pendidikan Sumenep</span>
    <span>Bismillah Melayani</span>
    <span>Dinas Pendidikan Sumenep</span>
    <span>Bismillah Melayani</span>
  </div>
</div>

<!-- ===== VISI MISI ===== -->
<section id="visi-misi" class="visi-misi">
    <div class="section-inner">
        <div class="section-head">
            <div>
                <div class="section-label">Profil Instansi</div>
                <div class="section-title">Visi & Misi</div>
            </div>
        </div>
        <div class="visi-grid">
            <div class="profile-summary-card reveal">
                <div class="icon"><i class="bi bi-eye"></i></div>
                <h3>Visi Utama</h3>
                <p>{!! nl2br(e($profil->visi ?? '')) !!}</p>
            </div>
            <div class="profile-summary-card reveal">
                <div class="icon"><i class="bi bi-bullseye"></i></div>
                <h3>Misi Utama</h3>
                @php
                    $misiLines = collect(preg_split('/\r\n|\r|\n/', trim($profil->misi ?? '')))
                        ->filter(fn ($l) => trim($l) !== '');
                @endphp
                <ol>
                    @foreach ($misiLines as $line)
                        @php($clean = preg_replace('/^\s*\d+[\.\)]\s*/', '', trim($line)))
                        <li>{{ $clean }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- ===== BERITA & PENGUMUMAN ===== -->
<section class="section section-alt">
  <div class="section-inner">
    <div class="section-head">
      <div>
        <div class="section-label">Informasi Terkini</div>
        <div class="section-title">Berita &amp; Pengumuman</div>
      </div>
      <a href="{{ route('berita.index') }}" class="link-all">Lihat semua</a>
    </div>
    <div class="news-layout">
      @if ($beritaUtama)
      <div class="news-featured-card">
        <div class="featured-img reveal">
          <div class="news-badge">Terbaru</div>
          @if ($beritaUtama->gambar)
            <img src="{{ Storage::url($beritaUtama->gambar) }}" alt="{{ $beritaUtama->judul }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
          @else
            <div class="news-img-icon">
              <svg viewBox="0 0 24 24" width="80" height="80"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l6 6v8a2 2 0 0 1-2 2z"/></svg>
            </div>
          @endif
          <div class="news-img-overlay"></div>
        </div>
        <div class="featured-body reveal">
          <div class="news-meta">Berita &middot; {{ $beritaUtama->tanggal_publish?->translatedFormat('d F Y') }}</div>
          <h3>{{ $beritaUtama->judul }}</h3>
          <p>{{ Str::limit(strip_tags($beritaUtama->isi), 150) }}</p>
          <a href="{{ route('berita.show', $beritaUtama->slug) }}" class="read-more">Baca selengkapnya</a>
        </div>
      </div>
      @endif

      <div class="news-sidebar">
        @forelse ($pengumuman as $row)
          <a href="{{ route('pengumuman.show', $row->slug) }}" class="news-list-card reveal" style="text-decoration:none;color:inherit;display:block">
            <div class="news-badge sidebar-badge" style="background:#166534;">Info</div>
            <div class="news-list-item">
              <h4>{{ $row->judul }}</h4>
              <span>{{ $row->tanggal->translatedFormat('d F Y') }}</span>
            </div>
          </a>
        @empty
          <div class="news-list-card reveal">
            <div class="news-list-item">
              <h4>Belum ada pengumuman.</h4>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</section>

<!-- ===== LAYANAN ===== -->
<section class="section">
    <div class="section-inner">
        <div class="section-head">
            <div>
                <div class="section-label">Pelayanan Publik</div>
                <div class="section-title">Layanan Kami</div>
            </div>
        </div>

        <div class="layanan-grid">

            <!-- Legalisir Ijazah -->
            <a href="{{ route('layanan.detail', 'legalisir-ijazah') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path
                            d="m22 21-3-3m0 0a5 5 0 1 0-7-7 5 5 0 0 0 7 7z" />
                    </svg>
                </div>
                <h4>Legalisir Ijazah</h4>
                <p>Pelayanan legalisir ijazah SD, SMP, dan Paket A, B, C untuk keperluan administrasi.</p>
            </a>

            <!-- Kesalahan Ijazah -->
            <a href="{{ route('layanan.detail', 'keterangan-kesalahan-ijazah') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14,2 14,8 20,8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                </div>
                <h4>Kesalahan Data Ijazah</h4>
                <p>Pelayanan penerbitan surat keterangan atas kesalahan penulisan pada ijazah.</p>
            </a>

            <!-- Ijin Operasional -->
            <a href="{{ route('layanan.detail', 'ijin-operasional') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path
                            d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path
                            d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <h4>Ijin Operasional</h4>
                <p>Pelayanan rekomendasi pendirian lembaga SD, SMP, PAUD, dan PNF swasta baru.</p>
            </a>

            <!-- Mutasi -->
            <a href="{{ route('layanan.detail', 'mutasi-siswa') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="6" />
                        <path
                            d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11" />
                    </svg>
                </div>
                <h4>Mutasi Siswa</h4>
                <p>Pelayanan rekomendasi mutasi siswa antar kabupaten maupun antar provinsi.</p>
            </a>

            <!-- BOS -->
            <a href="{{ route('layanan.detail', 'pencairan-bos') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path
                            d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <h4>Pencairan Dana BOS</h4>
                <p>Pelayanan rekomendasi pencairan Dana BOS setelah proses verifikasi berkas.</p>
            </a>

            <!-- PIP -->
            <a href="{{ route('layanan.detail', 'rekomendasi-pip') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <h4>Program Indonesia Pintar (PIP)</h4>
                <p>Pelayanan rekomendasi penyaluran Program Indonesia Pintar bagi peserta didik.</p>
            </a>

            <!-- Dapodik -->
            <a href="{{ route('layanan.detail', 'pelayanan-dapodik') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                </div>
                <h4>Pelayanan Dapodik</h4>
                <p>Pelayanan akun operator, NPSN, NPYP, serta approval data peserta didik pada Dapodik.</p>
            </a>

            <!-- Pensiun -->
            <a href="{{ route('layanan.detail', 'pengusulan-pensiun') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 12l2.5 2.5L16 9" />
                    </svg>
                </div>
                <h4>Pengusulan Pensiun</h4>
                <p>Pelayanan pengusulan pensiun bagi ASN di lingkungan Dinas Pendidikan.</p>
            </a>

            <!-- Cuti -->
            <a href="{{ route('layanan.detail', 'pengusulan-cuti') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <h4>Pengusulan Cuti</h4>
                <p>Pelayanan pengusulan cuti melahirkan, haji, umrah, dan cuti sakit bagi ASN.</p>
            </a>

            <!-- Gaji Berkala -->
            <a href="{{ route('layanan.detail', 'gaji-berkala') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="2" x2="12" y2="22" />
                        <path
                            d="M17 5H9.5a3.5 3.5 0 0 0 0 7H15a3.5 3.5 0 1 1 0 7H7" />
                    </svg>
                </div>
                <h4>Gaji Berkala</h4>
                <p>Pelayanan pengusulan kenaikan gaji berkala bagi ASN sesuai ketentuan.</p>
            </a>

            <!-- Ijin Belajar -->
            <a href="{{ route('layanan.detail', 'ijin-belajar') }}" class="layanan-card reveal"
                style="text-decoration:none;color:inherit;display:block">
                <div class="layanan-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path
                            d="M20 22V2H6.5A2.5 2.5 0 0 0 4 4.5v15" />
                    </svg>
                </div>
                <h4>Ijin Belajar / Tugas Belajar</h4>
                <p>Pelayanan pengusulan izin belajar atau tugas belajar bagi ASN di lingkungan Dinas Pendidikan.</p>
            </a>

        </div>
    </div>
</section>

<!-- ===== GALERI ===== -->
<section class="section section-alt">
  <div class="section-inner">
    <div class="section-head">
      <div>
        <div class="section-label">Dokumentasi Kegiatan</div>
        <div class="section-title">Galeri Foto</div>
      </div>
      <a href="{{ route('galeri.foto') }}" class="link-all">Lihat semua</a>
    </div>
    <div class="galeri-grid">
      @forelse ($galeri as $row)
        <div class="galeri-item reveal">
          @if ($row->gambar)
            <div class="galeri-bg" style="background-image: url('{{ Storage::url($row->gambar) }}'); background-size:cover; background-position:center;"></div>
          @else
            <div class="galeri-bg" style="background: linear-gradient(135deg, #1a3a5c, #2a5f7a);"></div>
          @endif
          <div class="galeri-overlay"><span>{{ $row->judul }}</span></div>
          <div class="galeri-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
        </div>
      @empty
        <p style="grid-column: 1/-1; text-align:center; padding:40px; color:#666;">Belum ada foto galeri.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ===== PEGAWAI ===== -->
<section class="section">
  <div class="section-inner">
    <div class="section-head">
      <div>
        <div class="section-label">Sumber Daya Manusia</div>
        <div class="section-title">Pimpinan &amp; Staff</div>
      </div>
      <a href="{{ route('profil.karyawan') }}" class="link-all">Lihat semua</a>
    </div>
    <div class="pegawai-grid">
      @forelse ($pegawai as $row)
        <div class="pegawai-card reveal">
          <div class="pegawai-avatar">
            <div class="pegawai-avatar-circle">
              @if ($row->foto)
                <img src="{{ Storage::url($row->foto) }}" alt="Foto" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
              @else
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              @endif
            </div>
          </div>
          <div class="pegawai-info">
            <div class="pegawai-name">{{ $row->nama }}</div>
            <div class="pegawai-jabatan">{{ $row->jabatan }}</div>
            <div class="pegawai-bidang">Staff</div>
          </div>
        </div>
      @empty
        <p style="grid-column: 1/-1; text-align:center; padding:40px; color:#666;">Belum ada data pegawai.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ===== PENGADUAN (Form) ===== -->
<section class="section section-alt" id="pengaduan">
  <div class="section-inner">
    @if ($errors->any())
      <div class="tiket-alert-error reveal" style="margin-bottom:24px">
        Mohon lengkapi Nama, Kategori, Judul, dan Isi Pengaduan sebelum mengirim.
      </div>
    @endif
    <div class="pengaduan-wrap reveal">
      <div class="pengaduan-text">
        <div class="section-label">Layanan Aspirasi</div>
        <div class="section-title">Sampaikan Pengaduan Anda</div>
        <p>Kami berkomitmen memberikan layanan terbaik. Sampaikan keluhan, saran, atau aspirasi Anda dan kami akan merespons secepatnya.</p>
        <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:20px;margin-bottom:20px">
          <div style="font-size:12px;font-weight:700;color:var(--gold-light);text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px">Cek Status Pengaduan</div>
          <form action="{{ route('pengaduan.cek') }}" method="GET" class="tiket-input">
            <input type="text" name="no_tiket" placeholder="Masukkan nomor tiket (contoh: TK-482913)" required/>
            <button type="submit">Cek &rarr;</button>
          </form>
        </div>
        <div style="display:flex;gap:20px;flex-wrap:wrap">
          <div style="display:flex;align-items:center;gap:8px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold-light)" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span style="font-size:13px;color:#A8BDD4">Respons dalam 3 hari kerja</span>
          </div>
          <div style="display:flex;align-items:center;gap:8px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold-light)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span style="font-size:13px;color:#A8BDD4">Data Anda terlindungi</span>
          </div>
        </div>
      </div>
      <div class="pengaduan-form">
        <div class="form-title">Form Pengaduan</div>
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" placeholder="Nama Anda" value="{{ old('nama') }}" required/>
            </div>
            <div class="form-group">
              <label>Nomor Telepon</label>
              <input type="text" name="telepon" placeholder="08xx-xxxx-xxxx" value="{{ old('telepon') }}"/>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="email@contoh.com" value="{{ old('email') }}"/>
          </div>
          <div class="form-group">
            <label>Kategori Pengaduan</label>
            <select name="kategori" required>
              <option value="">Pilih kategori...</option>
              <option value="sarana_prasarana">Sarana & Prasarana</option>
              <option value="kepegawaian">Kepegawaian</option>
              <option value="pelayanan">Pelayanan</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>
          <div class="form-group">
            <label>Judul Pengaduan</label>
            <input type="text" name="judul" placeholder="Ringkasan singkat pengaduan" value="{{ old('judul') }}" required/>
          </div>
          <div class="form-group">
            <label>Isi Pengaduan</label>
            <textarea name="isi" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('isi') }}</textarea>
          </div>
          <div class="form-group">
            <label>Lampiran (opsional, maksimal 3 file)</label>
            <input type="file" id="lampiran-input" name="lampiran[]" accept=".jpg,.jpeg,.png,.pdf" multiple/>
            <div id="lampiran-preview" class="lampiran-preview" aria-live="polite"></div>
          </div>
          <button type="submit" class="btn-submit">Kirim Pengaduan</button>
        </form>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('lampiran-input');
  var preview = document.getElementById('lampiran-preview');
  var selectedFiles = [];
  var maxFiles = 3;

  if (!input || !preview || typeof DataTransfer === 'undefined') {
    return;
  }

  function fileKey(file) {
    return [file.name, file.size, file.lastModified].join('|');
  }

  function syncInputFiles() {
    var dataTransfer = new DataTransfer();
    selectedFiles.forEach(function (file) {
      dataTransfer.items.add(file);
    });
    input.files = dataTransfer.files;
  }

  function renderPreview() {
    preview.innerHTML = '';

    if (selectedFiles.length === 0) {
      return;
    }

    selectedFiles.forEach(function (file, index) {
      var item = document.createElement('div');
      item.className = 'lampiran-preview-item';

      var name = document.createElement('span');
      name.className = 'lampiran-preview-name';
      name.textContent = file.name;

      var remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'lampiran-remove';
      remove.setAttribute('aria-label', 'Batalkan lampiran ' + file.name);
      remove.textContent = 'x';
      remove.addEventListener('click', function () {
        selectedFiles.splice(index, 1);
        syncInputFiles();
        renderPreview();
      });

      item.appendChild(name);
      item.appendChild(remove);
      preview.appendChild(item);
    });

    if (selectedFiles.length >= maxFiles) {
      var info = document.createElement('div');
      info.className = 'lampiran-limit-info';
      info.textContent = 'Maksimal 3 lampiran.';
      preview.appendChild(info);
    }
  }

  input.addEventListener('change', function () {
    var existing = selectedFiles.map(fileKey);
    Array.from(input.files).forEach(function (file) {
      if (selectedFiles.length >= maxFiles || existing.indexOf(fileKey(file)) !== -1) {
        return;
      }
      selectedFiles.push(file);
      existing.push(fileKey(file));
    });

    syncInputFiles();
    renderPreview();
  });
});
</script>
@endpush

@endsection