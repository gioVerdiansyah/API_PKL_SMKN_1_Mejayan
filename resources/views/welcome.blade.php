@extends('layouts.app')

@section('content')
    <section class="section gradient-banner">
        <div class="shapes-container">
            <div class="shape" data-aos="fade-down-left" data-aos-duration="1500" data-aos-delay="100"></div>
            <div class="shape" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100"></div>
            <div class="shape" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="200"></div>
            <div class="shape" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"></div>
            <div class="shape" data-aos="fade-down-left" data-aos-duration="1000" data-aos-delay="100"></div>
            <div class="shape" data-aos="fade-down-left" data-aos-duration="1000" data-aos-delay="100"></div>
            <div class="shape" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="300"></div>
            <div class="shape" data-aos="fade-down-right" data-aos-duration="500" data-aos-delay="200"></div>
            <div class="shape" data-aos="fade-down-right" data-aos-duration="500" data-aos-delay="100"></div>
            <div class="shape" data-aos="zoom-out" data-aos-duration="2000" data-aos-delay="500"></div>
            <div class="shape" data-aos="fade-up-right" data-aos-duration="500" data-aos-delay="200"></div>
            <div class="shape" data-aos="fade-down-left" data-aos-duration="500" data-aos-delay="100"></div>
            <div class="shape" data-aos="fade-up" data-aos-duration="500" data-aos-delay="0"></div>
            <div class="shape" data-aos="fade-down" data-aos-duration="500" data-aos-delay="0"></div>
            <div class="shape" data-aos="fade-up-right" data-aos-duration="500" data-aos-delay="100"></div>
            <div class="shape" data-aos="fade-down-left" data-aos-duration="500" data-aos-delay="0"></div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-2 order-md-1 text-center text-md-left">
                    <h1 class="text-white font-weight-bold mb-4">Aplikasi Presensi PKL SMKN 1 Mejayan</h1>
                    <p class="text-white mb-5">Adalah aplikasi untuk mempermudah melakukan presensi, jurnal, serta guru
                        pembimbing untuk melakukan presensi dan rekap kegiatan selama PKL.</p>
                    <h3 class="text-white">Aplikasi untuk: </h3>
                    <div class="d-flex" id="button-download">
                        <link rel="stylesheet" href="{{ asset('css/select-for.css') }}">
                        <div class="wrapper mr-3">
                            <div class="option">
                                <input class="input" type="radio" name="btn" value="option1" checked="">
                                <button class="btn" id="btn-siswa">
                                    <span class="span">Siswa</span>
                                </button>
                            </div>
                            <div class="option">
                                <input class="input" type="radio" name="btn" value="option2">
                                <button class="btn" id="btn-siswa">
                                    <span class="span">Pembimbing PKL</span>
                                </button>
                            </div>
                        </div>
                        <button class="button-download" type="button">
                            <span class="button__text"><i class="fa-brands fa-android"></i> Android</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35"
                                    id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg">
                                    <path
                                        d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z">
                                    </path>
                                    <path
                                        d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z">
                                    </path>
                                    <path
                                        d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z">
                                    </path>
                                </svg></span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-center order-1 order-md-2">
                    <img class="img-fluid" src="{{ asset('images/mobile/priview-user.png') }}" alt="screenshot">
                </div>
            </div>
        </div>
    </section>
    <!--====  End of Hero Section  ====-->

    <section class="section pt-0 position-relative pull-top">
        <div class="container" id="about">
            <div class="rounded shadow p-5 bg-white">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mt-5 mt-md-0 text-center">
                        <i class="ti-check-box text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Absensi Harian</h3>
                        <p class="regular text-muted">Mempermudah siswa PKL untuk melakukan absensi lewat aplikasi dan
                            mempermudah guru untuk merekap absensi siswa PKL.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-5 mt-md-0 text-center">
                        <i class="ti-pencil-alt text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Jurnal Harian</h3>
                        <p class="regular text-muted">Mempermudah siswa PKL untuk mengisi jurnal harian tanpa perlu menulis
                            manual.</p>
                    </div>
                    <div class="col-lg-4 col-md-12 mt-5 mt-lg-0 text-center">
                        <i class="ti-printer text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Cetak Rekap</h3>
                        <p class="regular text-muted">Mempermudah cetak rekap Absensi dan Jurnal tanpa harus mengkalkulasi
                            secara manual.</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--==================================
                            =            Feature Grid            =
                            ===================================-->
    <section class="feature section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 ml-auto justify-content-center">
                    <!-- Feature Mockup -->
                    <div class="image-content" data-aos="fade-right">
                        <img class="img-fluid" src="{{ asset('images/mobile/2-sidebar.png') }}" alt="iphone">
                    </div>
                </div>
                <div class="col-lg-6 mr-auto align-self-center">
                    <div class="feature-content">
                        <h2>Tentang Aplikasi</h2>
                        <p class="desc">
                            Aplikasi ini dibuat dengan tujuan untuk mempermudah baik siswa dan guru untuk mengelola presensi
                            selama PKL siswa berlangsung.
                        </p>

                        <p class="desc">
                            Pada siswa terdapat fitur utama untuk presensi absen harian yang dimana siswa hanya akan bisa
                            absen pada tempat DuDi/PKL nya, serta ada fitur izin jika siswa ingin melakukan izin, dan juga
                            ada fitur mengisi jurnal harian.
                        </p>

                        <p class="desc">
                            Pada guru/pengurus siswa PKL terdapat fitur pengelolaan absensi, jurnal, izin, serta cetak rekap
                            absensi dan jurnal siswa.Dan jika siswa mengisi jurnal dan melakukan izin maka pembimbing siswa
                            harus menyetujuinya atau menolaknya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature section pt-0" id="contact">
        <h1 class="text-center mb-3">Contact Me</h1>
        <div class="container">
            <div class="contact__wrapper shadow-lg mt-n9">
                <div class="row no-gutters">
                    <div class="col-lg-5 contact-info__wrapper gradient-brand-color p-5 order-lg-2">

                        <ul class="contact-info__list list-style--none position-relative z-index-101">
                            <li class="mb-4 pl-4 text-white">
                                <span class="position-absolute"><i class="fas fa-envelope"></i></span>
                                <a href="mailto:smknmejayan@yahoo.co.id" class="text-white">smknmejayan@yahoo.co.id</a>
                            </li>
                            <li class="mb-4 pl-4 text-white">
                                <span class="position-absolute"><i class="fas fa-phone"></i></span> (0351) 388490
                            </li>
                            <li class="mb-4 pl-4 text-white">
                                <span class="position-absolute"><i class="fas fa-map-marker-alt"></i></span> Jl. Imam
                                Bonjol No. 7 Pandean, Kec. Mejayan Kab. Madiun Kodepos 63153 Jawa Timur
                                <div class="mt-3">
                                    <a href="https://google.com/maps/place/SMKN+1+Mejayan/@-7.5560559,111.6585072,18.3z/data=!4m6!3m5!1s0x2e79c7fb585a947d:0xf2b189f11ed3a368!8m2!3d-7.5570422!4d111.6597938!16s%2Fg%2F11bw5y64zz?entry=ttu"
                                        target="_blank" class="text-link link--right-icon text-white">google maps <i
                                            class="link__icon fa fa-directions"></i></a>
                                </div>
                            </li>
                        </ul>

                        <figure class="figure position-absolute m-0 opacity-06 z-index-100" style="bottom:0; right: 10px">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="444px" height="626px">
                                <defs>
                                    <linearGradient id="PSgrad_1" x1="0%" x2="81.915%" y1="57.358%"
                                        y2="0%">
                                        <stop offset="0%" stop-color="rgb(255,255,255)" stop-opacity="1"></stop>
                                        <stop offset="100%" stop-color="rgb(0,54,207)" stop-opacity="0"></stop>
                                    </linearGradient>

                                </defs>
                                <path fill-rule="evenodd" opacity="0.302" fill="rgb(72, 155, 248)"
                                    d="M816.210,-41.714 L968.999,111.158 L-197.210,1277.998 L-349.998,1125.127 L816.210,-41.714 Z">
                                </path>
                                <path fill="url(#PSgrad_1)"
                                    d="M816.210,-41.714 L968.999,111.158 L-197.210,1277.998 L-349.998,1125.127 L816.210,-41.714 Z">
                                </path>
                            </svg>
                        </figure>
                    </div>

                    <div class="col-lg-7 contact-form__wrapper p-5 order-lg-1">
                        <div id="message-form"></div>
                        <form action="#" class="contact-form form-validate" id="form-contact-me">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="required-field" for="firstName">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="John" required>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="required-field" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="example@gmail.com" required>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label class="required-field" for="message">Saran dan masukkan</label>
                                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Saran anda..." required></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <button type="submit" name="submit" class="bg-primary btn btn-primary"
                                        id="button-send">Kirim</button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- End Contact Form Wrapper -->

                </div>
            </div>
        </div>
        <script>
            $("#form-contact-me").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: "{{ route('send-contact') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#name').val(),
                        email: $('#email').val(),
                        message: $('#message').val(),
                    },
                    dataType: "json",
                    beforeSend: function() {
                    $("#button-send").attr('type', 'button');
                    $("#button-send").html(`
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 101" class="inline w-4 h-4 mr-3 text-white animate-bounce" role="status" aria-hidden="true">
                            <circle fill="#ffffff" r="45" cy="50" cx="50"></circle>
                        </svg>
                        Mengirim...
                    `);
                    },
                    success: function(response) {
                        console.log(response);

                        if(response.success){
                            $("#message-form").html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            `);
                            $("#form-contact-me ")[0].reset();
                        }else{
                            $("#message-form").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            `);
                        }
                        $("#button-send").html(`Kirim`);
                        $("#button-send").attr('type', 'submit');
                    }
                });
            })
        </script>
    </section>
@endsection
