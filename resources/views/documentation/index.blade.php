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
    <div class="container">
        <h1 class="text-center">Dokumentasi Aplikasi: Inventaris Sarana dan Prasarana SMK</h1>
        <hr>

        <h2>1. Deskripsi Aplikasi</h2>
        <p>
            Aplikasi Invesapra ini adalah sistem manajemen inventaris sarana dan prasarana yang dirancang untuk mempermudah
            pengelolaan barang-barang yang ada di SMK.
            Fitur utama mencakup pengelolaan data inventaris, peminjaman, pengembalian barang, dan perhitungan denda atas
            keterlambatan atau kehilangan barang.
        </p>

        <h3>Fitur Utama:</h3>
        <ul>
            <li><strong>Manajemen Aset:</strong> Pengguna dapat menambah, mengedit, dan menghapus data inventaris sarana dan
                prasarana di sekolah.</li>
            <li><strong>Peminjaman Aset:</strong> Pengguna dapat meminjam inventaris untuk kegiatan sekolah dengan mencatat
                peminjaman dan tanggal pengembalian.</li>
            <li><strong>Pengembalian Aset:</strong> Pengguna dapat mengembalikan inventaris yang telah dipinjam dan sistem
                akan menghitung denda jika pengembalian terlambat.</li>
            <li><strong>Manajemen Denda:</strong> Admin dapat melihat dan mengelola denda atas keterlambatan atau
                kehilangan inventaris.</li>
        </ul>

        <h2>2. Instalasi</h2>
        <h3>Persyaratan:</h3>
        <ul>
            <li>PHP 7.4 atau lebih tinggi</li>
            <li>Composer</li>
            <li>Laravel 8.x atau lebih tinggi</li>
            <li>MySQL atau database lain yang kompatibel</li>
        </ul>

        <h3>Langkah-langkah Instalasi:</h3>
        <ol>
            <li><strong>Clone Repository</strong>
                <pre>git clone https://github.com/username/repository-name.git</pre>
            </li>
            <li><strong>Masuk ke Direktori Proyek</strong>
                <pre>cd repository-name</pre>
            </li>
            <li><strong>Instalasi Dependensi</strong>
                <pre>composer install</pre>
            </li>
            <li><strong>Konfigurasi .env</strong>
                Salin file `.env.example` ke `.env` dan atur konfigurasi database.
            </li>
            <li><strong>Jalankan Migrasi dan Seeder</strong>
                <pre>php artisan migrate</pre>
                Jika perlu, jalankan seeder:
                <pre>php artisan db:seed</pre>
            </li>
            <li><strong>Jalankan Server</strong>
                <pre>php artisan serve</pre>
            </li>
        </ol>

        <h2>3. Penggunaan</h2>

        <h3>Halaman Inventaris</h3>
        <p><strong>Menambahkan Aset:</strong> Admin dapat menambahkan inventaris baru di halaman <strong>Inventaris</strong>
            dengan mengisi nama, kategori, dan jumlah inventaris yang tersedia.</p>
        <p><strong>Mengedit Aset:</strong> Admin dapat mengubah informasi inventaris seperti nama, kategori, atau jumlah di
            halaman <strong>Inventaris</strong>.</p>
        <p><strong>Menghapus Aset:</strong> Admin dapat menghapus inventaris yang sudah tidak digunakan atau rusak.</p>

        <h3>Halaman Peminjaman</h3>
        <p><strong>Melakukan Peminjaman:</strong> Pengguna dapat meminjam inventaris melalui halaman
            <strong>Peminjaman</strong>, dengan memilih inventaris dan tanggal pengembalian.</p>
        <p><strong>Melihat Status Peminjaman:</strong> Pengguna dapat melihat status peminjaman dan tanggal pengembalian
            pada halaman yang sama.</p>

        <h3>Halaman Pengembalian Aset</h3>
        <p><strong>Melakukan Pengembalian:</strong> Pengguna dapat mengembalikan inventaris yang telah dipinjam. Sistem akan
            menghitung denda jika pengembalian terlambat.</p>
        <p><strong>Melihat Denda:</strong> Admin dapat melihat denda yang harus dibayar oleh pengguna yang terlambat
            mengembalikan inventaris.</p>

        <h2>4. Struktur Proyek</h2>
        <h3>Model</h3>
        <ul>
            <li><strong>Asset:</strong> Model untuk mengelola inventaris, dengan atribut `name`, `category`, `quantity`, dan
                `status`.</li>
            <li><strong>Borrowing:</strong> Model untuk mencatat peminjaman, dengan atribut `asset_id`, `borrowed_by`,
                `borrow_date`, dan `return_date`.</li>
            <li><strong>Fine:</strong> Model untuk mengelola denda, dengan atribut `fine_amount`, `paid_amount`, dan
                `status`.</li>
        </ul>

        <h3>Controller</h3>
        <ul>
            <li><strong>AssetController:</strong> Mengelola operasi CRUD untuk inventaris.</li>
            <li><strong>BorrowingController:</strong> Mengelola peminjaman dan pengembalian inventaris.</li>
            <li><strong>FineController:</strong> Mengelola pembayaran denda dan pengaturan denda atas keterlambatan atau
                kehilangan inventaris.</li>
        </ul>

        <h3>Views</h3>
        <ul>
            <li><strong>asset.index:</strong> Tampilan untuk melihat daftar inventaris yang ada di sekolah.</li>
            <li><strong>asset.create:</strong> Tampilan untuk menambah inventaris baru.</li>
            <li><strong>borrowing.index:</strong> Tampilan untuk melihat status peminjaman dan pengembalian inventaris.</li>
            <li><strong>fine.index:</strong> Tampilan untuk melihat dan mengelola denda.</li>
        </ul>

        <h2>5. Penyelesaian Masalah (Troubleshooting)</h2>
        <ul>
            <li><strong>Masalah: Aplikasi tidak dapat terkoneksi ke database</strong>
                <p>Pastikan konfigurasi database di file `.env` sudah benar dan database sudah dibuat.</p>
            </li>
            <li><strong>Masalah: Halaman tidak dapat dimuat</strong>
                <p>Jalankan <code>php artisan config:clear</code> dan <code>php artisan cache:clear</code> untuk
                    membersihkan cache.</p>
            </li>
        </ul>

        <h2>6. Lisensi</h2>
        <p>Aplikasi ini dilisensikan di bawah MIT License. Anda bebas untuk mengubah dan mendistribusikan aplikasi
            sesuai dengan ketentuan lisensi.</p>
    </div>
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
