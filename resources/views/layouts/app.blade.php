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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />

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
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Home</a>
                    </li>
                    <li class="nav-item dropdown @@pages">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Pages
                            <span><i class="ti-angle-down"></i></span>
                        </a>
                        <!-- Dropdown list -->
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item @@team" href="team.html">Team</a></li>
                            <li><a class="dropdown-item @@career" href="career.html">Career</a></li>
                            <li><a class="dropdown-item @@blog" href="blog.html">Blog</a></li>
                            <li><a class="dropdown-item @@blogSingle" href="blog-single.html">Blog
                                    Single</a></li>
                            <li><a class="dropdown-item @@privacy"
                                    href="privacy-policy.html">Privacy</a></li>
                            <li><a class="dropdown-item @@faq" href="FAQ.html">FAQ</a></li>
                            <li><a class="dropdown-item" href="sign-in.html">Sign In</a></li>
                            <li><a class="dropdown-item" href="sign-up.html">Sign Up</a></li>
                            <li><a class="dropdown-item" href="404.html">404</a></li>
                            <li><a class="dropdown-item" href="comming-soon.html">Coming Soon</a></li>

                            <li class="dropdown dropdown-submenu dropleft">
                                <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0501" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

                                <ul class="dropdown-menu" aria-labelledby="dropdown0501">
                                    <li><a class="dropdown-item" href="index.html">Submenu 21</a></li>
                                    <li><a class="dropdown-item" href="index.html">Submenu 22</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @@about">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item @@contact">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item ml-3">
                        <button class="button-login d-flex align-items-center" onclick="window.location.href = '{{ route('login') }}'"> Login Kakomli
                        </button>
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
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 m-md-auto align-self-center">
                        <div class="block">
                            <a href="index.html"><img src="{{ asset('images/app/logo-with-title.png') }}"
                                    class="w-50" alt="footer-logo"></a>
                            <!-- Social Site Icons -->
                            <ul class="social-icon list-inline">
                                <li class="list-inline-item">
                                    <a href="https://www.facebook.com/themefisher"><i class="ti-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://twitter.com/themefisher"><i class="ti-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.instagram.com/themefisher/"><i class="ti-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mt-5 mt-lg-0">
                        <div class="block-2">
                            <!-- heading -->
                            <h6>Product</h6>
                            <!-- links -->
                            <ul>
                                <li><a href="team.html">Teams</a></li>
                                <li><a href="blog.html">Blogs</a></li>
                                <li><a href="FAQ.html">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mt-5 mt-lg-0">
                        <div class="block-2">
                            <!-- heading -->
                            <h6>Resources</h6>
                            <!-- links -->
                            <ul>
                                <li><a href="sign-up.html">Singup</a></li>
                                <li><a href="sign-in.html">Login</a></li>
                                <li><a href="blog.html">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mt-5 mt-lg-0">
                        <div class="block-2">
                            <!-- heading -->
                            <h6>Company</h6>
                            <!-- links -->
                            <ul>
                                <li><a href="career.html">Career</a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="team.html">Investor</a></li>
                                <li><a href="privacy.html">Terms</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mt-5 mt-lg-0">
                        <div class="block-2">
                            <!-- heading -->
                            <h6>Company</h6>
                            <!-- links -->
                            <ul>
                                <li><a href="about.html">About</a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="team.html">Team</a></li>
                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
