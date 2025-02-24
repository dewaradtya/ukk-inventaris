@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <div>
                                    <h5 class="mb-0">Laporan Peminjaman</h5>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                    <div class="d-flex gap-2">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('report.export') }}" class="btn bg-gradient-success btn-sm">
                                                Export Data
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive px-4">
                                <table class="table table-hover table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Peminjaman
                                            </th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Pengembalian
                                            </th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Peminjaman
                                            </th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pegawai
                                            </th>
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Inventaris Dipinjam
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($borrowings as $borrowing)
                                            <tr>
                                                <td class="text-center">
                                                    <h6 class="mb-0 text-xs">
                                                        {{ \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d M Y') }}
                                                    </h6>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->translatedFormat('d M Y') : '-' }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge 
                                                        {{ $borrowing->loan_status === 'pending' ? 'bg-secondary' 
                                                            : ($borrowing->loan_status === 'borrow' ? 'bg-warning' 
                                                            : ($borrowing->loan_status === 'return' ? 'bg-success' 
                                                            : 'bg-danger')) }}">
                                                        {{ $borrowing->loan_status === 'pending' ? 'Menunggu Konfirmasi' 
                                                            : ($borrowing->loan_status === 'borrow' ? 'Dipinjam' 
                                                            : ($borrowing->loan_status === 'return' ? 'Dikembalikan' 
                                                            : 'Ditolak')) }}
                                                    </span>
                                                </td>                                                

                                                <td class="text-center">
                                                    <p class="text-xs mb-0">
                                                        {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}
                                                        </a>
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <ul class="text-xs mb-0">
                                                        @foreach ($borrowing->loanDetails as $loanDetail)
                                                            <li>
                                                                {{ $loanDetail->inventory->name ?? 'Inventaris Tidak Ditemukan' }}
                                                                ({{ $loanDetail->amount }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>                                            
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data peminjaman</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
