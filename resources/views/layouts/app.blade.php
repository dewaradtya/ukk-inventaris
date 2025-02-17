<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <title>Invesapra</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <style>
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .modal-body .fa-check-circle {
            color: #2dce89;
            animation: scaleIn 0.3s ease-in-out;
        }

        .modal-body .fa-times-circle {
            color: #e74c3c;
            animation: scaleIn 0.3s ease-in-out;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }

            70% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="g-sidenav-show">
    @auth
        @yield('auth')
    @endauth

    @guest
        @yield('guest')
    @endguest

    @if (session()->has('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-4">
                        <div class="mb-4">
                            <i class="fa fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="modal-title mb-3" id="successModalLabel">Success!</h4>
                        <p class="mb-4" id="successMessage"></p>
                        <button type="button" class="btn bg-success text-white" data-bs-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-4">
                        <div class="mb-4">
                            <i class="fa fa-times-circle text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="modal-title mb-3" id="errorModalLabel">Error!</h4>
                        <p class="mb-4" id="errorMessage"></p>
                        <button type="button" class="btn bg-danger text-white" data-bs-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="loadingOverlay"
        class="d-flex align-items-center justify-content-center bg-white position-fixed top-0 start-0 w-100 h-100 d-none"
        style="z-index: 9999;">
        <div class="spinner-grow text-primary" style="width: 5rem; height: 5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById("loadingOverlay").classList.add("d-none");

            window.addEventListener("beforeunload", function() {
                document.getElementById("loadingOverlay").classList.remove("d-none");
            });

            if (@json(session()->has('success'))) {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                document.getElementById('successMessage').textContent = @json(session('success'));
                successModal.show();

                setTimeout(() => {
                    successModal.hide();
                }, 5000);
            }

            if (@json(session()->has('error'))) {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.getElementById('errorMessage').textContent = @json(session('error'));
                errorModal.show();

                setTimeout(() => {
                    errorModal.hide();
                }, 5000);
            }
        });
    </script>

    <!-- Control Center for Soft Dashboard -->
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
</body>

</html>
