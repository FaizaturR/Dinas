<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Dinas Pendidikan')</title>
    <link rel="icon" type="image/png" href="{{ asset('admin-assets/img/Logo1.png') }}">
    <link href="{{ asset('admin-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --navy: #0B1F3A;
            --navy-mid: #162F55;
            --navy-light: #1E3F70;
            --gold: #C89B3C;
            --gold-light: #E8BF6A;
            --cream: #F7F4EE;
            --white: #FFFFFF;
            --text: #1A1A2E;
            --muted: #6B7280;
            --line: #E5E1D8;
        }

        a:not(.btn):not(.page-link):not(.dataTables_wrapper .dataTables_paginate a),
        .text-primary {
            color: inherit !important;
        }

        .sidebar .nav-link,
        .sidebar .collapse-item,
        .sidebar .sidebar-brand,
        .sidebar .sidebar-heading,
        .sidebar .nav-link span {
            color: white !important;
        }

        .bg-gradient-primary,
        .btn-primary,
        .sidebar .nav-item.active .nav-link,
        .page-item.active .page-link {
            background-color: #162F55 !important;
            border-color: #162F55 !important;
            background-image: none !important;
        }

        .sidebar.toggled .sidebar-brand-text {
            display: none !important;
        }

        .sidebar {
            width: 18rem !important;
        }

        .sidebar.toggled {
            width: 6.5rem !important;
        }

        .sidebar .collapse-inner {
            width: 100%;
            min-width: 16rem;
            padding: .5rem 0;
        }

        .sidebar .collapse-item {
            white-space: normal !important;
            word-break: break-word;
            line-height: 1.5;
            padding: .75rem 1.2rem;
            font-size: .9rem;
        }

        /* Jika sidebar dikecilkan */
        .sidebar.toggled .collapse-inner {
            min-width: 13rem;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <div id="wrapper">
        {{-- Sidebar --}}
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.berita.index') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('admin-assets/img/Logo1.png') }}" style="width:60px;height:60px;object-fit:contain;">
                </div>
                <div class="sidebar-brand-text d-flex flex-column" style="color:#fff !important;">
                    <div style="font-size:0.7rem;">Dinas Pendidikan</div>
                    <div style="font-size:0.5rem;"><i>Kabupaten Sumenep</i></div>
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.berita.index') }}">
                    <i class="fas fa-fw fa-newspaper"></i><span>Berita</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pengumuman.index') }}">
                    <i class="fas fa-fw fa-bullhorn"></i><span>Pengumuman</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGaleri">
                    <i class="fas fa-fw fa-images"></i><span>Galeri</span>
                </a>
                <div id="collapseGaleri" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.galeri.foto') }}">Foto</a>
                        <a class="collapse-item" href="{{ route('admin.galeri.prestasi') }}">Prestasi</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pengaduan.index') }}">
                    <i class="fas fa-fw fa-exclamation-triangle"></i><span>Pengaduan</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Instansi</div>

            <li class="nav-item {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.profil.edit') }}">
                    <i class="fas fa-fw fa-user"></i><span>Profil</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pegawai.index') }}">
                    <i class="fas fa-fw fa-user-friends"></i><span>Pegawai</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.bidang.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.bidang.index') }}">
                    <i class="fas fa-fw fa-building"></i><span>Bidang</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKegiatan">
                    <i class="fas fa-fw fa-calendar-check"></i><span>Kegiatan</span>
                </a>
                <div id="collapseKegiatan" class="collapse {{ request()->routeIs('admin.kegiatan.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @foreach (\App\Models\Bidang::orderBy('id')->get() as $b)
                        <a class="collapse-item {{ request()->route('bidang')?->id === $b->id ? 'active' : '' }}"
                            href="{{ route('admin.kegiatan.per-bidang', $b) }}">
                            {{ $b->nama }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.sakip.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.sakip.index') }}">
                    <i class="fas fa-fw fa-file-contract"></i><span>SAKIP</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            @if (auth()->user()->role === 'superadmin')
            <li class="nav-item {{ request()->routeIs('admin.kelola-admin.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.kelola-admin.index') }}">
                    <i class="fas fa-fw fa-user-shield"></i><span>Kelola Admin</span>
                </a>
            </li>
            @endif

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('admin-assets/img/profile.webp') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @if(session('success'))
                    <div id="notifAlert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div id="notifAlert" class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div id="notifAlert" class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $errors->first() }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dinas Pendidikan Kabupaten Sumenep {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <script src="{{ asset('admin-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            var alertBox = document.getElementById('notifAlert');

            if (alertBox) {
                setTimeout(function() {
                    $(alertBox).alert('close');
                }, 4000);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>