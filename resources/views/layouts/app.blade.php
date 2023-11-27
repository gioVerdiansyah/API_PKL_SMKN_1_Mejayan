<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Small Apps | Bootstrap App Landing Template</title>

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
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

    <!-- PLUGINS CSS STYLE -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/aos/aos.css') }}">

    {{-- CSS CDN --}}
    <script src="https://kit.fontawesome.com/981acb16d7.js" crossorigin="anonymous"></script>

    <!-- CUSTOM CSS -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">


    <nav class="navbar main-nav navbar-expand-lg px-2 px-sm-0 py-2 py-lg-0 position-fixed w-100">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>
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
                                <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0501"
                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">Sub Menu</a>

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
                        <button class="button-login d-flex align-items-center"> Login Guru
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
    </div>
    <!-- JAVASCRIPTS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('plugins/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('plugins/syotimer/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('plugins/aos/aos.js') }}"></script>
    <!-- google map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g"></script>
    <script src="{{ asset('plugins/google-map/gmap.js') }}"></script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
