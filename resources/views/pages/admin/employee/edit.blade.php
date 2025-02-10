@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Edit Pegawai</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('employee.update', $employee->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Pegawai Nama</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $employee->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nip" class="form-label">Pegawai NIP</label>
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                                id="nip" name="nip" value="{{ old('nip', $employee->nip) }}">
                                            @error('nip')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Pegawai Alamat</label>
                                        <textarea class="form-control @error('nip') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if (auth()->user()->level->name === 'Admin')
                                        <div class="mb-3">
                                            <label for="user_id">Pilih User</label>
                                            <select name="user_id" id="user_id"
                                                class="form-control @error('user_id') is-invalid @enderror">
                                                <option value="">-- Pilih User --</option>
                                                @foreach ($users as $user)
                                                    @if ($user->employee->isEmpty() || $user->employee->first()->id === $employee->id)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id', $employee->id_user) == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="card-footer">
                                        <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
