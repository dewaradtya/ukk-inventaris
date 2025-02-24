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
                                    <h5 class="mb-0">Manajemen Peminjaman</h5>
                                    <p class="text-muted small mb-0">Kelola data peminjaman</p>
                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                    <form action="{{ route('borrowing.index') }}" method="GET" class="w-100 w-sm-auto">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                                            <span class="input-group-text text-body">
                                                <i class="fas fa-search" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </form>

                                    <div class="d-flex gap-2">
                                        @if (Auth::check() && Auth::user()->level->name === 'Admin')
                                            <button id="export-selected" class="btn bg-gradient-success btn-sm">
                                                Export Data
                                            </button>
                                        @endif
                                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createBorrowingModal">
                                            Tambah Peminjaman
                                        </button>
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
                                                <input type="checkbox" id="select-all">
                                            </th>
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
                                            <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($borrowings as $borrowing)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="borrowing-checkbox"
                                                        value="{{ $borrowing->id }}">
                                                </td>
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
                                                        {{ $borrowing->loan_status === 'pending'
                                                            ? 'bg-secondary'
                                                            : ($borrowing->loan_status === 'borrow'
                                                                ? 'bg-warning'
                                                                : 'bg-danger') }}">
                                                        {{ $borrowing->loan_status === 'pending'
                                                            ? 'Menunggu Konfirmasi'
                                                            : ($borrowing->loan_status === 'borrow'
                                                                ? 'Dipinjam'
                                                                : 'Ditolak') }}
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



                                                <td class="text-center">
                                                    @if (Auth::check() && (Auth::user()->level->name === 'Admin' || Auth::user()->level->name === 'Operator'))
                                                        @if ($borrowing->loan_status === 'pending')
                                                            <form action="{{ route('borrowing.confirm', $borrowing->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" name="status" value="approved"
                                                                    class="btn btn-success p-2" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Setujui">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                                <button type="submit" name="status" value="rejected"
                                                                    class="btn btn-danger p-2" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Tolak">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    @if ($borrowing->loan_status === 'borrow')
                                                        <p class="text-xs mb-0">
                                                            <a href="#" class="open-action-modal text-info"
                                                                data-id="{{ $borrowing->id }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Klik untuk melakukan aksi"
                                                                data-edit="{{ route('borrowing.edit', $borrowing->id) }}"
                                                                data-proof="{{ route('borrowing.proof', $borrowing->id) }}"
                                                                data-delete="{{ route('borrowing.destroy', $borrowing->id) }}"
                                                                data-status="{{ route('borrowing.return', $borrowing->id) }}"
                                                                data-loan-status="{{ $borrowing->loan_status }}">
                                                                <i class="fas fa-ellipsis fa-2x"></i>
                                                            </a>
                                                        </p>
                                                    @endif

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const checkboxes = document.querySelectorAll(".borrowing-checkbox");
            const exportButton = document.getElementById("export-selected");

            selectAllCheckbox.addEventListener("change", function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            exportButton.addEventListener("click", function() {
                let selectedIds = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedIds.push(checkbox.value);
                    }
                });

                if (selectedIds.length === 0) {
                    alert("Silakan pilih setidaknya satu data untuk diekspor.");
                    return;
                }

                let exportUrl = "{{ route('borrowing.export') }}" + "?ids=" + selectedIds.join(",");
                window.location.href = exportUrl;
            });
        });
    </script>
@endsection
