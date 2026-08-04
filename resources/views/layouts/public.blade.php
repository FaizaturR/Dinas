<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dinas Pendidikan Kabupaten Sumenep')</title>
    <link rel="icon" type="image/png" href="{{ asset('user-assets/image/Logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/profil.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/layanan.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/galeri.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/pengaduan.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/berita.css') }}">
    <link rel="stylesheet" href="{{ asset('user-assets/css/footer.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')
</head>
<body id="top">

<header class="header">
  <div class="header-inner">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('user-assets/image/Logo1.png') }}" alt="Logo Dinas Pendidikan Sumenep" class="logo-img">
      <div class="brand-text">
        <h1>DINAS PENDIDIKAN</h1>
        <p>Kabupaten Sumenep</p>
      </div>
    </a>
    <nav>
      <a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class="active"' : '' }}>Beranda</a>

      <div class="nav-item dropdown">
        <a href="#" class="drop-toggle">Profil</a>
        <div class="dropdown-menu">
          <a href="{{ route('profil.selayang') }}">Selayang Pandang</a>
          <a href="{{ route('profil.struktur') }}">Struktur Organisasi</a>
          <a href="{{ route('profil.karyawan') }}">Data Karyawan</a>
          <a href="{{ route('profil.tupoksi') }}">Tugas Pokok Dan Fungsi</a>
          <a href="{{ route('profil.peta') }}">Peta Sekolah</a>
          <a href="{{ route('profil.kegiatan') }}">Kegiatan</a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="#" class="drop-toggle">Bidang - Bidang</a>
        <div class="dropdown-menu">
          <a href="{{ route('bidang.show', 'sekretariat') }}">Sekretariat</a>
          <a href="{{ route('bidang.show', 'paud') }}">PAUD dan PNF</a>
          <a href="{{ route('bidang.show', 'sd') }}">SD (Sekolah Dasar)</a>
          <a href="{{ route('bidang.show', 'smp') }}">SMP (Sekolah Menengah Pertama)</a>
          <a href="{{ route('bidang.show', 'ketenagaan') }}">Ketenagaan</a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="#" class="drop-toggle">Galeri</a>
        <div class="dropdown-menu">
          <a href="{{ route('galeri.foto') }}">Foto</a>
          <a href="{{ route('galeri.prestasi') }}">Prestasi</a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="#" class="drop-toggle">Informasi &amp; Layanan</a>
        <div class="dropdown-menu">
          <a href="{{ route('layanan.publik') }}">Layanan Publik</a>
          <a href="{{ route('sakip.index') }}">Sakip</a>
          <a href="{{ route('faq.index') }}">FAQ</a>
        </div>
      </div>
    </nav>
  </div>
</header>

<main>
    @yield('content')
</main>

<footer id="footer" class="footer dark-background">
  <div class="container">
    <h3>Dinas Pendidikan Kabupaten Sumenep</h3>
    <p>Jl. DR. Cipto No.35, Desa Kolor, Kecamatan Kota Sumenep, Jawa Timur 69417, Indonesia.</p>
    <div class="social-link">
      @php($profil = \App\Models\Profil::first())
      @if ($profil?->tiktok)
        <a href="{{ $profil->tiktok }}" target="_blank" rel="noopener" class="social-icon"><i class="bi bi-tiktok"></i></a>
      @endif
      @if ($profil?->facebook)
        <a href="{{ $profil->facebook }}" target="_blank" rel="noopener" class="social-icon"><i class="bi bi-facebook"></i></a>
      @endif
      @if ($profil?->instagram)
        <a href="{{ $profil->instagram }}" target="_blank" rel="noopener" class="social-icon"><i class="bi bi-instagram"></i></a>
      @endif
      @if ($profil?->youtube)
        <a href="{{ $profil->youtube }}" target="_blank" rel="noopener" class="social-icon"><i class="bi bi-youtube"></i></a>
      @endif
    </div>
    <div class="footer-divider"></div>
    <div class="copyright">
      <span>Copyright</span>
      <strong class="sitename">Disdik Kabupaten Sumenep</strong>
    </div>
  </div>
</footer>

<a href="#" class="scroll-top" aria-label="Kembali ke atas">↑</a>

<div id="lightbox" class="lightbox-overlay" onclick="closeLightbox()">
  <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
  <img id="lightbox-img" src="" alt="">
</div>
<script>
function openLightbox(src){
  document.getElementById('lightbox-img').src = src;
  document.getElementById('lightbox').classList.add('active');
}
function closeLightbox(){
  document.getElementById('lightbox').classList.remove('active');
}
document.addEventListener('keydown', function(e){
  if (e.key === 'Escape') closeLightbox();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.reveal').forEach(function(el){ el.classList.add('in-view'); });
    return;
  }
  var reveals = Array.from(document.querySelectorAll('.reveal'));
  var io = new IntersectionObserver(function(entries, observer){
    entries.forEach(function(entry){
      if (entry.isIntersecting) {
        var target = entry.target;
        var startIndex = reveals.indexOf(target);
        var maxAhead = 4;
        var delayStep = 80;
        for (var k = 0; k < maxAhead; k++){
          var el = reveals[startIndex + k];
          if (!el) break;
          var rect = el.getBoundingClientRect();
          if (rect.top <= window.innerHeight * 1.5){
            (function(e, d){
              setTimeout(function(){
                e.classList.add('in-view');
                observer.unobserve(e);
              }, d);
            })(el, k * delayStep);
          }
        }
      }
    });
  }, { threshold: 0.12 });
  reveals.forEach(function(el){ io.observe(el); });
});
</script>

@stack('scripts')
</body>
</html>