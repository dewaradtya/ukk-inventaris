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
                                    <h5 class="mb-0">Manajemen Pengembalian</h5>
                                    <p class="text-muted small mb-0">Kelola data pengembalian</p>
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
                                        @if (Auth::check() && Auth::user()->level->name === 'Admin')
                                            <button id="export-selected" class="btn bg-gradient-success btn-sm">
                                                Export Data
                                            </button>
                                        @endif
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
                                                Tanggal Dikembalikan
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
                                        @forelse ($returns as $return)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="return-checkbox"
                                                        value="{{ $return->id }}">
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="mb-0 text-xs">
                                                        {{ \Carbon\Carbon::parse($return->borrow_date)->translatedFormat('d M Y') }}
                                                    </h6>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $return->return_date ? \Carbon\Carbon::parse($return->return_date)->translatedFormat('d M Y') : '-' }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $return->actual_return_date ? \Carbon\Carbon::parse($return->actual_return_date)->translatedFormat('d M Y') : '-' }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $return->loan_status === 'borrow' ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $return->loan_status === 'borrow' ? 'Dipinjam' : 'Dikembalikan' }}
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <p class="text-xs mb-0">
                                                        {{ $return->employee->name ?? 'Tidak Diketahui' }}
                                                    </p>
                                                </td>

                                                <td class="text-center">
                                                    <ul class="text-xs mb-0">
                                                        @foreach ($return->loanDetails as $loanDetail)
                                                            <li>
                                                                {{ $loanDetail->inventory->name ?? 'Inventaris Tidak Ditemukan' }}
                                                                ({{ $loanDetail->amount }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs mb-0">
                                                        <a href="#" class="open-action-modal text-danger"
                                                            data-id="{{ $return->id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Klik untuk melakukan aksi"
                                                            data-edit="{{ route('return.edit', $return->id) }}"
                                                            data-proof="{{ route('return.proof', $return->id) }}"
                                                            data-delete="{{ route('borrowing.destroy', $return->id) }}"
                                                            data-loan-status="{{ $return->loan_status }}">
                                                            <i class="fas fa-ellipsis fa-2x"></i>
                                                        </a>
                                                    </p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada data pengembalian
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $returns->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('pages.admin.return.modal')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const checkboxes = document.querySelectorAll(".return-checkbox");
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
