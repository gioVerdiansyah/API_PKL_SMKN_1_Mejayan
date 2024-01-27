<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.3.67/css/materialdesignicons.min.css"
        integrity="sha512-nRzny9w0V2Y1/APe+iEhKAwGAc+K8QYCw4vJek3zXhdn92HtKt226zHs9id8eUq+uYJKaH2gPyuLcaG/dE5c7A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/flatpickr/flatpickr.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('cssAdmin/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/demo1/style.min.css') }}">
    <!-- End layout styles -->

    {{-- Date Picker --}}
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/pickr/themes/classic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/flatpickr/flatpickr.min.css') }}">

    {{-- Dropify --}}
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/dropify/dist/dropify.min.css') }}">

    <!-- JQuery -->
    <script src="{{ asset('cssAdmin/js/jquery-ini.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- core:js -->
    <script src="{{ asset('cssAdmin/vendors/core/core.js') }}"></script>

    {{-- CSS PERSETUJUAN --}}
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/persetujuan/persetujuan.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/app/Logo_SMK.png') }}" />
</head>

<body>
    <div class="main-wrapper">

        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    PKL.SMKN 1 Mejayan
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav">
                    {{-- Sidebar start here --}}
                    <li class="nav-item nav-category">Main</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="home"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Data-Data</li>
                    <li class="nav-item {{ request()->routeIs('admin.persetujuan') ? 'active' : '' }}">
                        <a href="{{ route('kakomli.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="cpu"></i>
                            <span class="link-title">Data Kakomli</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.siswa.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="users"></i>
                            <span class="link-title">Data Siswa</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.dudi.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dudi.index') }}" class="nav-link">
                            <i class="mdi mdi-factory"></i>
                            <span class="link-title ms-3">Data Dudi</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.pengurus-pkl.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.pengurus-pkl.index') }}" class="nav-link">
                            <i class="fa-solid fa-user-tie"></i>
                            <span class="link-title ms-3">Pengurus PKL</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.siswa-kelompok.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kelompok-siswa.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="grid"></i>
                            <span class="link-title">Kelompok Siswa</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Rekap Pendataan</li>
                    <li class="nav-item {{ request()->routeIs('admin.rekap_pendataan.dudi.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.rekap_pendataan.dudi.show_download') }}" class="nav-link">
                            <i class="link-icon" data-feather="book"></i>
                            <span class="link-title">Rekap List DuDi</span>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.rekap_pendataan.pemetaan_dudi.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.rekap_pendataan.pemetaan_dudi.show_download') }}" class="nav-link">
                            <i class="link-icon" data-feather="book-open"></i>
                            <span class="link-title">Pemetaan DuDi</span>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.rekap_pendataan.show_print_absensi_siswa') ? 'active' : '' }}">
                        <a href="{{ route('admin.rekap_pendataan.show_print_absensi_siswa') }}" class="nav-link">
                            <i class="fa-solid fa-check-to-slot"></i>
                            <span class="link-title m-4">Rekap Absensi</span>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.rekap_pendataan.show_print_jurnal_siswa') ? 'active' : '' }}">
                        <a href="{{ route('admin.rekap_pendataan.show_print_jurnal_siswa') }}" class="nav-link">
                            <i class="fa-solid fa-list-check"></i>
                            <span class="link-title m-3">Rekap Jurnal</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">Core</li>
                    <li class="nav-item {{ request()->routeIs('admin.authorizationQR') ? 'active' : '' }}">
                        <a href="{{ route('admin.authorizationQR') }}" class="nav-link">
                            <i class="fa-solid fa-qrcode"></i>
                            <span class="link-title m-3">authorizationQR WA</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item nav-category">List</li>
                    <li class="nav-item @if (request()->routeIs('mou.create') or request()->routeIs('mou.edit') or request()->routeIs('testimoni.create') or request()->routeIs('testimoni.edit')) active @endif">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#list" role="button"
                            aria-expanded="false" aria-controls="berita">
                            <i class="link-icon" data-feather="list"></i>
                            <span class="link-title">List-list</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="list">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="" class="nav-link">Kakomli</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    {{-- Sidebar ends here --}}
                </ul>
            </div>
        </nav>
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="wd-30 ht-30 rounded-circle" src="{{ asset('images/app/Logo_SMK.png') }}"
                                    alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="mb-3">
                                        <img class="wd-80 ht-80 rounded-circle"
                                            src="{{ asset('images/app/Logo_SMK.png') }}" alt="">
                                    </div>
                                    <div class="text-center">
                                        <p class="tx-16 fw-bolder">{{ config('app.name') }}</p>
                                        {{-- <p class="tx-12 text-muted">{{ \App\Models\ProfileCompany::get('email')[0]->email }}</p> --}}
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2">
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="text-body ms-0" id="button-logout">
                                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                                <span>Log Out</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->

            <div class="page-content">
                @yield('content')
            </div>

            <!-- partial:partials/_footer.html -->
            <footer
                class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
                <p class="text-muted mb-1 mb-md-0">Copyright © 2023 <a
                        href="https://www.google.com/search?q=hummatech&rlz=1C1FKPE_idID1058ID1058&oq=hummatech&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIPCAEQLhgKGMcBGNEDGIAEMgkIAhAAGAoYgAQyBggDEEUYPDIGCAQQRRg8MgYIBRBFGDzSAQgxNzIxajBqN6gCALACAA&sourceid=chrome&ie=UTF-8"
                        target="_blank">{{ config('app.name') }}</a>.</p>
                <p class="text-muted">Di buat oleh Hummaprofile <i class="mb-1 text-primary ms-1 icon-sm"
                        data-feather="heart"></i></p>
            </footer>
            <!-- partial -->

        </div>
    </div>

    <!-- endinject -->
    @if (session('message'))
        <script>
            Swal.fire({
                icon: "{{ session('message')['icon'] ?? 'question' }}",
                title: `{{ session('message')['title'] ?? 'Tidak ada keteerangan' }}`,
                text: `{{ session('message')['text'] ?? 'Tidak ada keterangan' }}`,
            })
        </script>
    @endif
    <!-- Plugin js for this page -->
    <script src="{{ asset('cssAdmin/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('cssAdmin/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('cssAdmin/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ asset('cssAdmin/js/dashboard-light.js') }}"></script>
    <!-- End custom js for this page -->

    {{-- Dropify --}}
    <script src="{{ asset('cssAdmin/vendors/dropify/dist/dropify.min.js') }}"></script>
    <script src="{{ asset('cssAdmin/js/dropify.js') }}"></script>

    {{-- Data Picker --}}
    <script src="{{ asset('cssAdmin/vendors/flatpickr/flatpickr.min.js') }}"></script>
    {{-- <script src="{{ asset('vendors/flatpickr/flatpickr.min.js') }}"></script> --}}
    <script src="{{ asset('cssAdmin/js/flatpickr.js') }}"></script>
</body>

</html>
