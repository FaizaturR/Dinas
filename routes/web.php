<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BidangHalamanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\SakipController;
use App\Http\Controllers\Admin\SakipController as AdminSakipController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelolaAdminController;
use App\Http\Controllers\FaqController;


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{berita}', [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::post('/berita-kategori', [AdminBeritaController::class, 'storeKategoriAjax'])->name('berita.kategori.store');

    Route::get('/pengumuman', [AdminPengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [AdminPengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan/{pengaduan}/tanggapi', [AdminPengaduanController::class, 'tanggapi'])->name('pengaduan.tanggapi');
    Route::get('/pengaduan/{pengaduan}/unduh', [AdminPengaduanController::class, 'unduh'])->name('pengaduan.unduh');

    Route::get('/bidang', [BidangController::class, 'index'])->name('bidang.index');
    Route::post('/bidang', [BidangController::class, 'store'])->name('bidang.store');
    Route::put('/bidang/{bidang}', [BidangController::class, 'update'])->name('bidang.update');
    Route::delete('/bidang/{bidang}', [BidangController::class, 'destroy'])->name('bidang.destroy');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');

    Route::get('/sakip', [AdminSakipController::class, 'index'])->name('sakip.index');
    Route::post('/sakip', [AdminSakipController::class, 'store'])->name('sakip.store');
    Route::put('/sakip/{sakip}', [AdminSakipController::class, 'update'])->name('sakip.update');
    Route::delete('/sakip/{sakip}', [AdminSakipController::class, 'destroy'])->name('sakip.destroy');

    Route::get('/galeri/foto', [AdminGaleriController::class, 'foto'])->name('galeri.foto');
    Route::get('/galeri/prestasi', [AdminGaleriController::class, 'prestasi'])->name('galeri.prestasi');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

    Route::get('/kegiatan/bidang/{bidang}', [KegiatanController::class, 'perBidang'])->name('kegiatan.per-bidang');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/kelola-admin', [KelolaAdminController::class, 'index'])->name('kelola-admin.index');
    Route::post('/kelola-admin', [KelolaAdminController::class, 'store'])->name('kelola-admin.store');
    Route::put('/kelola-admin/{kelolaAdmin}', [KelolaAdminController::class, 'update'])->name('kelola-admin.update');
    Route::delete('/kelola-admin/{kelolaAdmin}', [KelolaAdminController::class, 'destroy'])->name('kelola-admin.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('pengaduan.store');
Route::get('/pengaduan/cek', [PengaduanController::class, 'cek'])
    ->middleware('throttle:20,1')
    ->name('pengaduan.cek');
Route::get('/pengaduan/{no_tiket}/unduh-tiket', [PengaduanController::class, 'unduhTiket'])
    ->name('pengaduan.unduh-tiket');

Route::get('/profil/selayang-pandang', [ProfilController::class, 'selayang'])->name('profil.selayang');
Route::get('/profil/struktur-organisasi', [ProfilController::class, 'struktur'])->name('profil.struktur');
Route::get('/profil/data-karyawan', [ProfilController::class, 'karyawan'])->name('profil.karyawan');
Route::get('/profil/tugas-pokok-dan-fungsi', [ProfilController::class, 'tupoksi'])->name('profil.tupoksi');
Route::get('/profil/peta-sekolah', [ProfilController::class, 'peta'])->name('profil.peta');
Route::get('/profil/kegiatan', [ProfilController::class, 'kegiatan'])->name('profil.kegiatan');

Route::get('/galeri/foto', [GaleriController::class, 'foto'])->name('galeri.foto');
Route::get('/galeri/prestasi', [GaleriController::class, 'prestasi'])->name('galeri.prestasi');

Route::get('/bidang/{slug}', [BidangHalamanController::class, 'show'])->name('bidang.show')
    ->where('slug', 'sekretariat|paud|sd|smp|ketenagaan');

Route::get('/layanan/sakip', [SakipController::class, 'index'])->name('sakip.index');
Route::get('/layanan/publik', [LayananController::class, 'publik'])->name('layanan.publik');
Route::get('/layanan/faq', [FaqController::class, 'index'])->name('faq.index');

Route::get('/layanan/{slug}', [LayananController::class, 'detail'])->name('layanan.detail')
    ->where('slug', '[a-z0-9\-]+');



require __DIR__.'/auth.php';
