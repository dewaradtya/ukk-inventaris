@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <h5 class="mb-0">Manajemen Pengguna</h5>
                                <p class="text-muted small mb-0">Kelola data pengguna</p>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                <form action="{{ route('user-management.index') }}" method="GET" class="w-100 w-sm-auto">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Cari nama atau email..." value="{{ request('search') }}">
                                        <span class="input-group-text text-body"><i class="fas fa-search"
                                                aria-hidden="true"></i></span>
                                    </div>
                                </form>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('level.index') }}" class="btn bg-gradient-info btn-sm">
                                        Level
                                    </a>
                                    <button href="#" class="btn bg-gradient-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#createUserManagementModal">Tambah Pengguna</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive px-4">
                            <table class="table table-hover table-striped align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Photo
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Creation Date
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <div>
                                                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/default-avatar.jpg') }}"
                                                        alt="{{ $user->name }}" class="avatar avatar-sm me-3 rounded-circle">
                                                </div>
                                            </td>                                            
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->level->name ?? 'N/A' }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $user->created_at->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user-management.edit', $user->id) }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <form action="{{ route('user-management.destroy', $user->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cursor-pointer bg-transparent border-0"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                                                        style="background: none;">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.admin.management-user.create')
@endsection
