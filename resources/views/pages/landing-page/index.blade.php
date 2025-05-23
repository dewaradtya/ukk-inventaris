<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invesapra</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets1/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/css/fontawesome.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark menu shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="">
                <img src="images/logo1.png" alt="logo image">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">faq</a></li>
                    </li>
                </ul>
                <button type="button" class="rounded-pill btn-rounded"
                    onclick="window.location.href='{{ auth()->check() ? url('dashboard') : route('login') }}'">
                    {{ auth()->check() ? 'Dashboard' : 'Login' }} <span><i class="fas fa-arrow-right"></i></span>
                </button>

            </div>
        </div>
    </nav>

    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                            START SECTION 2 - THE INTRO SECTION
/////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <section id="home" class="intro-section">
        <div class="container">
            <div class="row align-items-center text-white">
                <!-- START THE CONTENT FOR THE INTRO  -->
                <div class="col-md-6 intros text-start">
                    <h1 class="display-2">
                        <span class="display-2--intro">Selamat Datang di Invesapra!</span>
                        <span class="display-2--description lh-base">
                            Solusi modern untuk manajemen inventaris sarana dan prasarana di SMK. Mudah, cepat, dan
                            efisien!
                        </span>
                    </h1>
                    <button type="button" class="rounded-pill btn-rounded"
                        onclick="window.location.href='{{ auth()->check() ? url('dashboard') : route('login') }}'">
                        {{ auth()->check() ? 'Dashboard' : 'Mulai Sekarang' }}
                        <span><i class="fas fa-arrow-right"></i></span>
                    </button>
                </div>
                <!-- START THE CONTENT FOR THE VIDEO -->
                <div class="col-md-6 intros text-end">
                    <div class="video-box">
                        <img src="images/arts/intro-section-illustration.png" alt="video illutration" class="img-fluid">
                        <a href="#" class="glightbox position-absolute top-50 start-50 translate-middle">
                            <span>
                                <i class="fas fa-play-circle"></i>
                            </span>
                            <span class="border-animation border-animation--border-1"></span>
                            <span class="border-animation border-animation--border-2"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1"
                d="M0,160L48,176C96,192,192,224,288,208C384,192,480,128,576,133.3C672,139,768,213,864,202.7C960,192,1056,96,1152,74.7C1248,53,1344,107,1392,133.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////
                             START SECTION 3 - THE CAMPANIES SECTION
////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <section id="campanies" class="campanies">
        <div class="container">
            <div class="row text-center">
                <h4 class="fw-bold lead mb-3">Dipercaya oleh Instansi Pendidikan dan Mitra</h4>
                <div class="heading-line mb-5"></div>
            </div>
        </div>
        <!-- START THE CAMPANIES CONTENT  -->
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-1.png" alt="Campany 1 logo" title="Campany 1 Logo"
                            class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-2.png" alt="Campany 2 logo" title="Campany 2 Logo"
                            class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-3.png" alt="Campany 3 logo" title="Campany 3 Logo"
                            class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-4.png" alt="Campany 4 logo" title="Campany 4 Logo"
                            class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-5.png" alt="Campany 5 logo" title="Campany 5 Logo"
                            class="img-fluid">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="campanies__logo-box shadow-sm">
                        <img src="images/campanies/campany-6.png" alt="Campany 6 logo" title="Campany 6 Logo"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////
                         START SECTION 4 - THE SERVICES
///////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section id="services" class="services">
        <div class="container">
            <div class="row text-center">
                <h1 class="display-3 fw-bold">Layanan Kami</h1>
                <div class="heading-line mb-1"></div>
            </div>
            <div class="row pt-2 pb-2 mt-0 mb-3">
                <div class="col-md-6 border-right">
                    <div class="bg-white p-3">
                        <h2 class="fw-bold text-capitalize text-center">
                            Layanan kami mencakup semua kebutuhan manajemen inventaris sekolah
                        </h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-4 text-start">
                        <p class="fw-light">
                            Dari pencatatan inventaris hingga pelaporan analitik, kami memastikan semua proses dilakukan
                            dengan mudah dan cepat, sesuai kebutuhan sekolah Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Manajemen Inventaris -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
                    <div class="services__content">
                        <div class="icon d-block fas fa-boxes"></div>
                        <h3 class="display-3--title mt-1">Manajemen Inventaris</h3>
                        <p class="lh-lg">
                            Kami membantu mencatat, memonitor, dan mengelola inventaris sarana dan prasarana sekolah
                            secara digital dengan mudah.
                        </p>
                        <button type="button" class="rounded-pill btn-rounded border-primary">Pelajari Lebih Lanjut
                            <span><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-end">
                    <div class="services__pic">
                        <img src="images/services/service-1.png" alt="marketing illustration" class="img-fluid">
                    </div>
                </div>
            </div>

            <!-- Analitik dan Pelaporan -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-start">
                    <div class="services__pic">
                        <img src="images/services/service-2.png" alt="marketing illustration" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
                    <div class="services__content">
                        <div class="icon d-block fas fa-chart-line"></div>
                        <h3 class="display-3--title mt-1">Analitik dan Pelaporan</h3>
                        <p class="lh-lg">
                            Lakukan pelaporan inventaris lengkap dan dapatkan analitik untuk pengambilan keputusan yang
                            lebih baik.
                        </p>
                        <button type="button" class="rounded-pill btn-rounded border-primary">Pelajari Lebih Lanjut
                            <span><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sistem Pelacakan -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
                    <div class="services__content">
                        <div class="icon d-block fas fa-search-location"></div>
                        <h3 class="display-3--title mt-1">Sistem Pelacakan</h3>
                        <p class="lh-lg">
                            Lacak keberadaan inventaris penting secara real-time dan hindari risiko kehilangan atau
                            kerusakan.
                        </p>
                        <button type="button" class="rounded-pill btn-rounded border-primary">Pelajari Lebih Lanjut
                            <span><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-end">
                    <div class="services__pic">
                        <img src="images/services/service-3.png" alt="marketing illustration" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////
                               START SECTION 5 - THE TESTIMONIALS
/////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section id="testimonials" class="testimonials">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1"
                d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
            </path>
        </svg>
        <div class="container">
            <div class="row text-center text-white">
                <h1 class="display-3 fw-bold">Testimoni</h1>
                <hr style="width: 100px; height: 3px; " class="mx-auto">
                <p class="lead pt-1">what our clients are saying</p>
            </div>

            <!-- START THE CAROUSEL CONTENT  -->
            <div class="row align-items-center">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- CAROUSEL ITEM 1 -->
                        <div class="carousel-item active">
                            <!-- testimonials card  -->
                            <div class="testimonials__card">
                                <p class="lh-lg">
                                    <i class="fas fa-quote-left"></i>
                                    Tim ini memberikan hasil yang melampaui ekspektasi. Mereka benar-benar memahami
                                    visi kami dan mewujudkannya. Sangat direkomendasikan!
                                    <i class="fas fa-quote-right"></i>
                                <div class="ratings p-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                </p>
                            </div>
                            <!-- client picture  -->
                            <div class="testimonials__picture">
                                <img src="images/testimonials/client-1.jpg" alt="client-1 picture"
                                    class="rounded-circle img-fluid">
                            </div>
                            <!-- client name & role  -->
                            <div class="testimonials__name">
                                <h3>Patrick Muriungi</h3>
                                <p class="fw-light">CEO & founder</p>
                            </div>
                        </div>
                        <!-- CAROUSEL ITEM 2 -->
                        <div class="carousel-item">
                            <!-- testimonials card  -->
                            <div class="testimonials__card">
                                <p class="lh-lg">
                                    <i class="fas fa-quote-left"></i>
                                    Tim ini memberikan hasil yang melampaui ekspektasi. Mereka benar-benar memahami
                                    visi kami dan mewujudkannya. Sangat direkomendasikan!
                                    <i class="fas fa-quote-right"></i>
                                <div class="ratings p-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                </p>
                            </div>
                            <!-- client picture  -->
                            <div class="testimonials__picture">
                                <img src="images/testimonials/client-2.jpg" alt="client-2 picture"
                                    class="rounded-circle img-fluid">
                            </div>
                            <!-- client name & role  -->
                            <div class="testimonials__name">
                                <h3>Joy Marete</h3>
                                <p class="fw-light">Finance Manager</p>
                            </div>
                        </div>
                        <!-- CAROUSEL ITEM 3 -->
                        <div class="carousel-item">
                            <!-- testimonials card  -->
                            <div class="testimonials__card">
                                <p class="lh-lg">
                                    <i class="fas fa-quote-left"></i>
                                    Tim ini memberikan hasil yang melampaui ekspektasi. Mereka benar-benar memahami
                                    visi kami dan mewujudkannya. Sangat direkomendasikan!
                                    <i class="fas fa-quote-right"></i>
                                <div class="ratings p-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                </p>
                            </div>
                            <!-- client picture  -->
                            <div class="testimonials__picture">
                                <img src="images/testimonials/client-3.jpg" alt="client-3 picture"
                                    class="rounded-circle img-fluid">
                            </div>
                            <!-- client name & role  -->
                            <div class="testimonials__name">
                                <h3>ClaireBelle Zawadi</h3>
                                <p class="fw-light">Global brand manager</p>
                            </div>
                        </div>
                        <!-- CAROUSEL ITEM 4 -->
                        <div class="carousel-item">
                            <!-- testimonials card  -->
                            <div class="testimonials__card">
                                <p class="lh-lg">
                                    <i class="fas fa-quote-left"></i>
                                    Tim ini memberikan hasil yang melampaui ekspektasi. Mereka benar-benar memahami
                                    visi kami dan mewujudkannya. Sangat direkomendasikan!
                                    <i class="fas fa-quote-right"></i>
                                <div class="ratings p-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                </p>
                            </div>
                            <!-- client picture  -->
                            <div class="testimonials__picture">
                                <img src="images/testimonials/client-4.jpg" alt="client-4 picture"
                                    class="rounded-circle img-fluid">
                            </div>
                            <!-- client name & role  -->
                            <div class="testimonials__name">
                                <h3>Uhuru Kenyatta</h3>
                                <p class="fw-light">C.E.O & Founder</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-light fas fa-long-arrow-alt-left" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        </button>
                        <button class="btn btn-outline-light fas fa-long-arrow-alt-right" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1"
                d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </section>

    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                       START SECTION 6 - THE FAQ
//////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section id="faq" class="faq">
        <div class="container">
            <div class="row text-center">
                <h1 class="display-3 fw-bold text-uppercase">FAQ</h1>
                <div class="heading-line"></div>
                <p class="lead">Pertanyaan yang Sering Diajukan, Dapatkan Informasi Sebelum Berinvestasi dengan
                    Invesapra</p>
            </div>
            <!-- ACCORDION CONTENT  -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <!-- ACCORDION ITEM 1 -->
                        <div class="accordion-item shadow mb-3">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Apa saja fitur utama dari Invesapra?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Invesapra menawarkan fitur-fitur unggulan,</strong> seperti manajemen
                                    inventaris yang terpusat, pelacakan sarana dan prasarana secara real-time,
                                    pengelolaan laporan otomatis, serta antarmuka yang mudah digunakan untuk semua
                                    pengguna, baik admin maupun guru.
                                </div>
                            </div>
                        </div>
                        <!-- ACCORDION ITEM 2 -->
                        <div class="accordion-item shadow mb-3">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Apakah saya perlu membayar setelah masa percobaan?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Ya,</strong> setelah masa percobaan gratis selama 30 hari, Anda dapat
                                    memilih paket berlangganan sesuai kebutuhan sekolah Anda. Kami menawarkan opsi
                                    pembayaran bulanan atau tahunan yang fleksibel.
                                </div>
                            </div>
                        </div>
                        <!-- ACCORDION ITEM 3 -->
                        <div class="accordion-item shadow mb-3">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    Bagaimana cara memulai setelah masa percobaan?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Mudah sekali!</strong> Setelah masa percobaan, cukup pilih paket langganan
                                    Anda di dashboard akun. Kami menyediakan panduan langkah demi langkah untuk membantu
                                    proses transisi Anda.
                                </div>
                            </div>
                        </div>
                        <!-- ACCORDION ITEM 4 -->
                        <div class="accordion-item shadow mb-3">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    Apakah saya bisa mendapatkan pengembalian dana jika tidak puas?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Tentu!</strong> Kami menawarkan kebijakan pengembalian dana dalam 14 hari
                                    setelah pembayaran, jika Anda merasa Invesapra tidak memenuhi kebutuhan Anda.
                                    Hubungi tim dukungan kami untuk informasi lebih lanjut.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ///////////////////////////////////////////////////////////////////////////////////////////
                           START SECTION 9 - THE FOOTER
///////////////////////////////////////////////////////////////////////////////////////////////-->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- CONTENT FOR THE MOBILE NUMBER  -->
                <div class="col-md-4 col-lg-4 contact-box pt-1 d-md-block d-lg-flex d-flex">
                    <div class="contact-box__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-call"
                            viewBox="0 0 24 24" stroke-width="1" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            <path d="M15 7a2 2 0 0 1 2 2" />
                            <path d="M15 3a6 6 0 0 1 6 6" />
                        </svg>
                    </div>
                    <div class="contact-box__info">
                        <a href="#" class="contact-box__info--title">+62 123 456 789</a>
                        <p class="contact-box__info--subtitle"> Sen-Jum 09.00-17.00 wib</p>
                    </div>
                </div>
                <!-- CONTENT FOR EMAIL  -->
                <div class="col-md-4 col-lg-4 contact-box pt-1 d-md-block d-lg-flex d-flex">
                    <div class="contact-box__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-opened"
                            viewBox="0 0 24 24" stroke-width="1" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="3 9 12 15 21 9 12 3 3 9" />
                            <path d="M21 9v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                            <line x1="3" y1="19" x2="9" y2="13" />
                            <line x1="15" y1="13" x2="21" y2="19" />
                        </svg>
                    </div>
                    <div class="contact-box__info">
                        <a href="#" class="contact-box__info--title">infoinvesapra@gmail.com</a>
                        <p class="contact-box__info--subtitle">Online support</p>
                    </div>
                </div>
                <!-- CONTENT FOR LOCATION  -->
                <div class="col-md-4 col-lg-4 contact-box pt-1 d-md-block d-lg-flex d-flex">
                    <div class="contact-box__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2"
                            viewBox="0 0 24 24" stroke-width="1" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="18" y2="6.01" />
                            <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />
                            <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15" />
                            <line x1="9" y1="4" x2="9" y2="17" />
                            <line x1="15" y1="15" x2="15" y2="20" />
                        </svg>
                    </div>
                    <div class="contact-box__info">
                        <a href="#" class="contact-box__info--title">Pasuruan, Indonesia</a>
                        <p class="contact-box__info--subtitle">PS 170225, ID</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- START THE SOCIAL MEDIA CONTENT  -->
        <div class="footer-sm" style="background-color: #212121;">
            <div class="container">
                <div class="row py-4 text-center text-white">
                    <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                        terhubung dengan kami di media sosial
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- START THE CONTENT FOR THE CAMPANY INFO -->
        <div class="container mt-5">
            <div class="row text-white justify-content-center mt-3 pb-3">
                <div class="col-12 col-sm-6 mx-auto">
                    <h5 class="text-capitalize fw-bold">Invesapra</h5>
                    <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
                    <p class="lh-lg">
                        Solusi modern untuk manajemen inventaris sarana dan prasarana di SMK. Mudah, cepat, dan
                        efisien!
                    </p>
                </div>
                <div class="col-12 col-sm-3 mb-4 mx-auto">
                    <h5 class="text-capitalize fw-bold">Menu</h5>
                    <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
                    <ul class="list-inline campany-list">
                        <li><a href="/">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#faq">Faq</a></li>
                    </ul>
                </div>
                <div class="col-12 col-sm-3 mb-4 mx-auto">
                    <h5 class="text-capitalize fw-bold">useful links</h5>
                    <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
                    <ul class="list-inline campany-list">
                        <li><a href="user-profile"> Your Account</a></li>
                        <li><a href="register">create an account</a></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- START THE COPYRIGHT INFO  -->
        <div class="footer-bottom pt-5 pb-5">
            <div class="container">
                <div class="row text-center text-white">
                    <div class="col-12">
                        <div class="footer-bottom__copyright">
                            &COPY; Copyright 2025 <a href="#">Invesapra</a> | Created by Dewa Raditya
                            Rochman<br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP BUTTON  -->
    <a href="#" class="shadow btn-primary rounded-circle back-to-top">
        <i class="fas fa-chevron-up"></i>
    </a>




    <script src="{{ asset('assets1/vendors/glightbox/js/glightbox.min.js') }}"></script>

    <script type="text/javascript">
        const lightbox = GLightbox({
            'touchNavigation': true,
            'href': 'https://www.youtube.com/watch?v=J9lS14nM1xg',
            'type': 'video',
            'source': 'youtube', //vimeo, youtube or local
            'width': 900,
            'autoPlayVideos': 'true',
        });
    </script>
    <script src="{{ asset('assets1/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
