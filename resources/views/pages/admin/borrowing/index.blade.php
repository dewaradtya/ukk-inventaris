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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Peminjaman
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Pengembalian
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status Peminjaman
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pegawai
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Inventaris Dipinjam
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($borrowings as $borrowing)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0 text-xs">
                                                        {{ \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d M Y') }}
                                                    </h6>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->translatedFormat('d M Y') : '-' }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge {{ $borrowing->loan_status === 'borrow' ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $borrowing->loan_status === 'borrow' ? 'Dipinjam' : 'Dikembalikan' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <p class="text-xs mb-0">
                                                        {{ $borrowing->employee->name ?? 'Tidak Diketahui' }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <ul class="text-xs mb-0">
                                                        @foreach ($borrowing->loanDetails as $loanDetail)
                                                            <li>
                                                                {{ $loanDetail->inventory->name ?? 'Inventaris Tidak Ditemukan' }}
                                                                ({{ $loanDetail->amount }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ route('borrowing.edit', $borrowing->id) }}"
                                                        class="btn btn-outline-primary p-2">
                                                        <i class="fa fa-pen text-primary fa-lg" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit"></i>
                                                    </a>
                                                    <form action="{{ route('borrowing.destroy', $borrowing->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger p-2"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                            <i class="fa fa-trash fa-lg"></i>
                                                        </button>
                                                    </form>
                                                    @if (Auth::check() &&
                                                            (Auth::user()->level->name === 'Admin' || Auth::user()->level->name === 'Operator') &&
                                                            $borrowing->loan_status === 'borrow')
                                                        <form
                                                            action="{{ route('borrowing.updateStatus', $borrowing->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="loan_status" value="return">
                                                            <button type="submit" class="btn btn-outline-success p-2"
                                                                onclick="return confirm('Apakah Anda yakin ingin mengubah status peminjaman ini?')"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Selesai">
                                                                <i class="fa fa-check fa-lg"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada data peminjaman
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
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
@endsection
