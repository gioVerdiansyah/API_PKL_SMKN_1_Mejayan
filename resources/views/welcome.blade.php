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
                    <p class="text-white mb-5">Adalah aplikasi untuk mempermudah melakukan presensi, jurnal, serta guru pembimbing untuk melakukan presensi dan rekap kegiatan selama PKL.</p>
                    <div class="d-flex flex-col">
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
                    <img class="img-fluid" src="{{ asset('images/feature/preview-1.png') }}" alt="screenshot">
                </div>
            </div>
        </div>
    </section>
    <!--====  End of Hero Section  ====-->

    <section id="about" class="section pt-0 position-relative pull-top">
        <div class="container">
            <div class="rounded shadow p-5 bg-white">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mt-5 mt-md-0 text-center">
                        <i class="ti-check-box text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Absensi Harian</h3>
                        <p class="regular text-muted">Mempermudah siswa PKL untuk melakukan absensi lewat aplikasi dan mempermudah guru untuk merekap absensi siswa PKL.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-5 mt-md-0 text-center">
                        <i class="ti-pencil-alt text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Jurnal Harian</h3>
                        <p class="regular text-muted">Mempermudah siswa PKL untuk mengisi jurnal harian tanpa perlu menulis manual.</p>
                    </div>
                    <div class="col-lg-4 col-md-12 mt-5 mt-lg-0 text-center">
                        <i class="ti-printer text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5 ">Cetak Rekap</h3>
                        <p class="regular text-muted">Mempermudah cetak rekap Absensi dan Jurnal tanpa harus mengkalkulasi secara manual.</p>
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
                        <img class="img-fluid" src="images/feature/feature-new-01.jpg" alt="iphone">
                    </div>
                </div>
                <div class="col-lg-6 mr-auto align-self-center">
                    <div class="feature-content">
                        <!-- Feature Title -->
                        <h2>Increase your productivity with <a
                                href="https://themefisher.com/products/small-apps-free-app-landing-page-template/">Small
                                Apps</a></h2>
                        <!-- Feature Description -->
                        <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut
                            aliquip ex ea commodo consequat.</p>
                    </div>
                    <!-- Testimonial Quote -->
                    <div class="testimonial">
                        <p>
                            "InVision is a window into everything that's being designed at Twitter. It gets all of our
                            best work in one
                            place."
                        </p>
                        <ul class="list-inline meta">
                            <li class="list-inline-item">
                                <img src="images/testimonial/feature-testimonial-thumb.jpg" alt="">
                            </li>
                            <li class="list-inline-item">Jonathon Andrew , Themefisher.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- To Top -->
    <div class="scroll-top-to">
        <i class="ti-angle-up"></i>
    </div>

    @endsection
