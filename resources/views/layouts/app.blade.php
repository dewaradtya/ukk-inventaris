<!DOCTYPE html>

@if (\Request::is('rtl'))
    <html dir="rtl" lang="ar">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>Invesapra</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" >
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100 {{ \Request::is('rtl') ? 'rtl' : '' }}">
    @auth
        @yield('auth')
    @endauth

    @guest
        @yield('guest')
    @endguest

    @if (session()->has('success'))
        <div id="success-alert"
            class="position-fixed alert alert-success text-white rounded top-3 end-3 text-sm py-2 px-4 shadow-lg"
            style="z-index: 1050;">
            <p class="m-0">{{ session('success') }}</p>
        </div>
    @endif

    <div id="loadingOverlay"
        class="d-flex align-items-center justify-content-center bg-white position-fixed top-0 start-0 w-100 h-100 d-none"
        style="z-index: 9999;">
        <div class="spinner-grow text-primary" style="width: 5rem; height: 5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    @if (session('error'))
        <div id="error-alert"
            class="position-fixed alert alert-danger text-white top-3 end-3 text-sm py-2 px-4 shadow-lg"
            style="z-index: 1050;">
            <p class="m-0">{{ session('error') }}</p>
        </div>
    @endif


    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.style.display = 'none', 1000);
            }

            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.style.display = 'none', 1000);
            }
        }, 5000);
    </script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loadingOverlay").classList.add("d-none");

            window.addEventListener("beforeunload", function() {
                document.getElementById("loadingOverlay").classList.remove("d-none");
            });
        });

        window.onload = function() {
            document.getElementById("loadingOverlay").classList.add("d-none");
        };
    </script>


    <!-- Control Center for Soft Dashboard -->
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
</body>

</html>
