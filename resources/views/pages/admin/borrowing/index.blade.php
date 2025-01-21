@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Tabel Peminjaman</h6>
                            </div>
                            <button class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createBorrowingModal">
                                Tambah Peminjaman
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Tanggal Peminjaman</th>
                                            <th
                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Tanggal Pengembalian</th>
                                            <th
                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Status Peminjaman</th>
                                            <th
                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Pegawai</th>
                                            <th
                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($borrowings as $borrowing)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $borrowing->borrow_date }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">
                                                        {{ $borrowing->return_date ?? '-' }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $borrowing->loan_status }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm mb-0">
                                                        {{ $borrowing->employee->name ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('borrowing.edit', $borrowing->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('borrowing.destroy', $borrowing->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus borrowing ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available</td>
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

    @include('pages.admin.borrowing.create')
@endsection
