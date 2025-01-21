@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Tabel Inventaris</h6>
                            </div>
                            <button class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createInventoryModal">
                                Tambah Inventaris
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Nama</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Kondisi</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Jumlah</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Tanggal Registrasi</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Kode</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Tipe</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Ruangan</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Petugas</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventories as $inventory)
                                            <tr>
                                                <td>{{ $inventory->name }}</td>
                                                <td>{{ $inventory->condition }}</td>
                                                <td>{{ $inventory->amount }}</td>
                                                <td>{{ $inventory->register_date }}</td>
                                                <td>{{ $inventory->code }}</td>
                                                <td>{{ $inventory->type->name ?? 'N/A' }}</td>
                                                <td>{{ $inventory->room->name ?? 'N/A' }}</td>
                                                <td>{{ $inventory->officer->name ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus inventory ini?')">Hapus</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('pages.admin.inventory.create')
@endsection
