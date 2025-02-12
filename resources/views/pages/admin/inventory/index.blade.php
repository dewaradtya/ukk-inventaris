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
                                    <h5 class="mb-0">Manajemen Inventaris</h5>
                                    <p class="text-muted small mb-0">Kelola data inventaris</p>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                    <form action="{{ route('inventory.index') }}" method="GET" class="w-100 w-sm-auto">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Cari.." value="{{ request('search') }}">
                                            <span class="input-group-text text-body"><i class="fas fa-search"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </form>

                                    <div class="d-flex gap-2">
                                        <button id="export-selected" class="btn bg-gradient-success btn-sm">
                                            Export Data
                                        </button>
                                        <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createInventoryModal">
                                            Tambah Inventaris
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="px-4 mt-2">
                                <form action="{{ route('inventory.index') }}" method="GET">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <select class="form-select" name="condition">
                                                <option value="">Semua Kondisi</option>
                                                <option value="baik"
                                                    {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak"
                                                    {{ request('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="hilang"
                                                    {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="type">
                                                <option value="">Semua Jenis</option>
                                                @foreach ($types ?? [] as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ request('type') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="room">
                                                <option value="">Semua Ruangan</option>
                                                @foreach ($rooms ?? [] as $room)
                                                    <option value="{{ $room->id }}"
                                                        {{ request('room') == $room->id ? 'selected' : '' }}>
                                                        {{ $room->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex gap-2">
                                            <button type="submit" class="btn btn-secondary w-100">
                                                <i class="fas fa-filter me-1"></i> Terap
                                            </button>
                                            <a href="{{ route('inventory.index') }}" class="btn btn-light w-100">
                                                <i class="fas fa-times me-1"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                                Kondisi</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Jumlah</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tanggal Registrasi</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Kode</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tipe</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Ruangan</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Petugas</th>
                                            <th
                                                class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventories as $inventory)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="inventory-checkbox"
                                                        value="{{ $inventory->id }}">
                                                </td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->name }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge bg-{{ $inventory->condition === 'baik' ? 'success' : ($inventory->condition === 'rusak' ? 'warning' : 'danger') }}">
                                                        {{ $inventory->condition }}
                                                    </span>
                                                </td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->amount }}</td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->register_date }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-dark font-weight-bold text-light">{{ $inventory->code }}</span>
                                                </td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->type->name ?? 'N/A' }}</td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->room->name ?? 'N/A' }}</td>
                                                <td class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $inventory->user->name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('inventory.edit', $inventory->id) }}"
                                                        class="btn btn-outline-primary p-2">
                                                        <i class="fa fa-pen text-primary fa-lg" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit"></i>
                                                    </a>
                                                    <form action="{{ route('inventory.destroy', $inventory->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger p-2"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus inventaris ini?')"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                            <i class="fa fa-trash fa-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $inventories->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('pages.admin.inventory.create')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const checkboxes = document.querySelectorAll(".inventory-checkbox");
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

                let exportUrl = "{{ route('inventory.export') }}" + "?ids=" + selectedIds.join(",");
                window.location.href = exportUrl;
            });
        });
    </script>
@endsection
