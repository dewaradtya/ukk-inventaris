@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Manajemen Denda</h5>
                                <p class="text-muted small mb-0">Kelola pembayaran denda pegawai</p>
                            </div>

                            <div class="col-md-3 mb-2">
                                <form action="{{ route('fine.index') }}" method="GET" class="w-100 w-sm-auto">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Cari nama..." value="{{ request('search') }}">
                                        <span class="input-group-text text-body">
                                            <i class="fas fa-search" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="row mx-4 mt-4">
                                <div class="col-md-3 mb-2">
                                    <div class="card bg-gradient-warning border-0">
                                        <div class="card-body">
                                            <h6 class="mb-1 text-white">Total Denda</h6>
                                            <h4 class="mb-0 text-white">Rp
                                                {{ number_format($totalFines ?? 0, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card bg-gradient-success border-0">
                                        <div class="card-body">
                                            <h6 class="mb-1 text-white">Sudah Dibayar</h6>
                                            <h4 class="mb-0 text-white">Rp {{ number_format($totalPaid ?? 0, 0, ',', '.') }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card bg-gradient-danger border-0">
                                        <div class="card-body">
                                            <h6 class="mb-1 text-white">Belum Dibayar</h6>
                                            <h4 class="mb-0 text-white">Rp
                                                {{ number_format($totalUnpaid ?? 0, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card bg-gradient-info border-0">
                                        <div class="card-body">
                                            <h6 class="mb-1 text-white">Total Pegawai</h6>
                                            <h4 class="mb-0 text-white">{{ $totalEmployees ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive p-4">
                                <table class="table table-hover table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Pegawai</th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Denda</th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sudah Dibayar</th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sisa Pembayaran</th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($fines as $fine)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-3 bg-primary rounded-circle">
                                                            {{ strtoupper(substr($fine->borrowing->employee->name ?? 'XX', 0, 2)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $fine->borrowing->employee->name ?? 'Pegawai Tidak Ditemukan' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">Rp
                                                        {{ number_format($fine->fine_amount, 0, ',', '.') }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">Rp
                                                        {{ number_format($fine->paid_amount, 0, ',', '.') }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">Rp
                                                        {{ number_format($fine->remaining_amount, 0, ',', '.') }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge 
                                                        {{ $fine->status == 'paid' ? 'bg-success' : ($fine->status == 'partial' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ $fine->status == 'paid' ? 'Lunas' : ($fine->status == 'partial' ? 'Sebagian Dibayar' : 'Belum Lunas') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-success p-2 open-pay-modal"
                                                        data-id="{{ $fine->id }}"
                                                        data-employee="{{ $fine->borrowing->employee->name ?? 'Pegawai Tidak Ditemukan' }}"
                                                        data-total="{{ $fine->fine_amount }}"
                                                        data-paid="{{ $fine->paid_amount }}"
                                                        data-remaining="{{ $fine->remaining_amount }}"
                                                        data-bs-toggle="modal" data-bs-target="#payModal">
                                                        <i class="fas fa-money-bill-wave text-success fa-lg"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Bayar"></i>
                                                    </button>

                                                    @if ($fine->payment_proof)
                                                        <button class="btn btn-outline-info p-2 open-proof-modal"
                                                            data-proof="{{ asset('storage/' . $fine->payment_proof) }}"
                                                            data-bs-toggle="modal" data-bs-target="#proofModal">
                                                            <i class="fas fa-file-image fa-lg text-info"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Lihat Bukti Pembayaran"></i>
                                                        </button>
                                                    @endif

                                                    <form action="{{ route('fine.destroy', $fine->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger p-2"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus denda ini?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                            <i class="fa fa-trash fa-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data denda</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $fines->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="proofModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="proofImage" src="" class="img-fluid rounded" alt="Bukti Pembayaran">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-proof-modal").forEach(button => {
                button.addEventListener("click", function() {
                    const proofImage = this.getAttribute("data-proof");
                    document.getElementById("proofImage").setAttribute("src", proofImage);
                });
            });
        });
    </script>


    @include('pages.admin.fine.pay')
@endsection
