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
                                    <h5 class="mb-0">Manajemen Jenis Inventaris</h5>
                                    <p class="text-muted small mb-0">Kelola data jenis inventaris</p>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                    <form action="{{ route('type.index') }}" method="GET" class="w-100 w-sm-auto">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                                            <span class="input-group-text text-body"><i class="fas fa-search"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <button id="export-selected" class="btn bg-gradient-success btn-sm">
                                            Export Data
                                        </button>
                                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createTypeModal">
                                            Tambah Jenis
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
                                                Nama</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Kode</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Informasi</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($types as $type)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="type-checkbox"
                                                        value="{{ $type->id }}">
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $type->name }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-dark font-weight-bold text-light">{{ $type->code }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $type->information }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('type.edit', $type->id) }}"
                                                        class="btn btn-outline-primary p-2">
                                                        <i class="fa fa-pen text-primary fa-lg" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit"></i>
                                                    </a>
                                                    <form action="{{ route('type.destroy', $type->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger p-2"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus ruang ini?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                            <i class="fa fa-trash fa-lg"></i>
                                                        </button>
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
                            <div class="d-flex justify-content-center mt-3">
                                {{ $types->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('pages.admin.type.create')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const checkboxes = document.querySelectorAll(".type-checkbox");
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

                let exportUrl = "{{ route('type.export') }}" + "?ids=" + selectedIds.join(",");
                window.location.href = exportUrl;
            });
        });
    </script>
@endsection
