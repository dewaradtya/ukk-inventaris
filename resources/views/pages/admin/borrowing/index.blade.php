@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <div>
                                    <h6 class="mb-0">Tabel Peminjaman</h6>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                    <form action="{{ route('room.index') }}" method="GET" class="w-100 w-sm-auto">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                                            <span class="input-group-text text-body">
                                                <i class="fas fa-search" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </form>

                                    <div class="d-flex gap-2">
                                        <button class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                            data-bs-target="#createBorrowingModal">
                                            Tambah Peminjaman
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
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
                                            <tr class="borrow-row" data-id="{{ $borrowing->id }}"
                                                data-edit="{{ route('borrowing.edit', $borrowing->id) }}"
                                                data-proof="{{ route('borrowing.proof', $borrowing->id) }}"
                                                data-delete="{{ route('borrowing.destroy', $borrowing->id) }}"
                                                data-status="{{ route('borrowing.updateStatus', $borrowing->id) }}"
                                                data-loan-status="{{ $borrowing->loan_status }}">
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
                                                        class="badge {{ $borrowing->loan_status === 'borrow' ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $borrowing->loan_status === 'borrow' ? 'Dipinjam' : 'Dikembalikan' }}
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs mb-0">
                                                        {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}
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
                                                <td colspan="5" class="text-center">Belum ada data peminjaman</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $borrowings->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('pages.admin.borrowing.create')
    @include('pages.admin.borrowing.modal')
@endsection
