<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Presensi PKL SMKN 1 Mejayan</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Bootstrap App Landing Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Small Apps Template v1.0">

    <!-- theme meta -->
    <meta name="theme-name" content="small-apps" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/app/Logo_SMK.png') }}" />

    <!-- PLUGINS CSS STYLE -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/aos/aos.css') }}">

    {{-- CSS CDN --}}
    <script src="https://kit.fontawesome.com/981acb16d7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CUSTOM CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</head>

<body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">
    <nav class="navbar main-nav navbar-expand-lg px-2 px-sm-0 py-2 py-lg-0 position-fixed w-100">
        <div class="container">
            <div class="w-50">
                <a class="navbar-brand" href="{{ route('index') }}"><img
                        src="{{ asset('images/app/logo-with-title-dark.png') }}" class="w-100" alt="logo"></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto d-flex .flex-lg-row align-items-lg-center align-items-start">
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#">Home</a>
                    </li>
                    <li class="nav-item @@about">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item @@contact">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ml-3">
                        @if (Auth::guard('kakomli')->check())
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <img src="{{ asset(Auth::guard('kakomli')->user()->photo_profile) }}"
                                            alt="Photo Profile" class="rounded-circle" width="30">
                                    </a>
                                    <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                            <div class="mb-3">
                                                <img src="{{ asset(Auth::guard('kakomli')->user()->photo_profile) }}"
                                                    alt="Photo Profile" class="rounded-circle" width="30">
                                            </div>
                                            <div class="text-center">
                                                <p class="tx-16 fw-bolder">{{ Auth::guard('kakomli')->user()->nama }}
                                                </p>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled p-1">
                                            <li class="dropdown-item py-2">
                                                <form action="{{ route('logout') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="text-body ms-0 btn btn-warning"
                                                        id="button-logout">
                                                        <span>Log Out</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <button class="button-login d-flex align-items-center"
                                onclick="window.location.href = '{{ route('login') }}'"> Login Kakomli</button>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="bg-light" style="padding: 60px 0 5px 0">
        @yield('content')
    </main>

    <!--============================
=            Footer            =
=============================-->
    <footer>
        <div class="text-center bg-dark py-4">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <small class="text-secondary">Copyright &copy;</small>
                <small class="text-secondary w-75">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>. Designed &amp; Developed by Siswa RPL SMKN 1 Mejayan
                </small>
            </div>
        </div>
    </footer>
    <!-- JAVASCRIPTS -->
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const bodyHeight = document.body.clientHeight;
            const windowHeight = window.innerHeight;

            if (bodyHeight < windowHeight) {
                const footer = document.querySelector('footer');
                footer.style.position = 'absolute';
                footer.style.bottom = '0';
                footer.style.width = '100%';
            }
        });
    </script>
    @if (session('message'))
        <script>
            Swal.fire({
                icon: "{{ session('message')['icon'] ?? 'question' }}",
                title: "{{ session('message')['title'] ?? 'Tidak ada keterangan' }}",
                text: "{{ session('message')['text'] ?? 'Tidak ada keterangan...' }}",
            });
        </script>
    @endif
    <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/aos/aos.js') }}"></script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
