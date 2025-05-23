@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Edit Inventory</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $inventory->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="condition" class="form-label">Kondisi</label>
                                            <select class="form-control @error('condition') is-invalid @enderror"
                                                id="condition" name="condition" required>
                                                <option value="" disabled
                                                    {{ old('condition', $inventory->condition) == '' ? 'selected' : '' }}>
                                                    Pilih
                                                    Kondisi</option>
                                                <option value="baik"
                                                    {{ old('condition', $inventory->condition) == 'baik' ? 'selected' : '' }}>
                                                    Baik</option>
                                                <option value="rusak"
                                                    {{ old('condition', $inventory->condition) == 'rusak' ? 'selected' : '' }}>
                                                    Rusak</option>
                                                <option value="hilang"
                                                    {{ old('condition', $inventory->condition) == 'hilang' ? 'selected' : '' }}>
                                                    Hilang</option>
                                            </select>
                                            @error('condition')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                                id="amount" name="amount"
                                                value="{{ old('amount', $inventory->amount) }}" min="1">
                                            @error('amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="register_date" class="form-label">Tanggal Registrasi</label>
                                            <input type="date"
                                                class="form-control @error('register_date') is-invalid @enderror"
                                                id="register_date" name="register_date"
                                                value="{{ old('register_date', $inventory->register_date) }}">
                                            @error('register_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kode Barang</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                id="code" name="code" value="{{ old('code', $inventory->code) }}">
                                            @error('code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_type" class="form-label">Tipe Barang</label>
                                            <select class="form-control @error('id_type') is-invalid @enderror"
                                                id="id_type" name="id_type">
                                                <option value="" disabled selected>Pilih Tipe Barang</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ old('id_type', $inventory->id_type) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_room" class="form-label">Ruangan</label>
                                            <select class="form-control @error('id_room') is-invalid @enderror"
                                                id="id_room" name="id_room">
                                                <option value="" disabled selected>Pilih Ruangan</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}"
                                                        {{ old('id_room', $inventory->id_room) == $room->id ? 'selected' : '' }}>
                                                        {{ $room->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_room')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_user" class="form-label">Petugas</label>
                                            <select class="form-control @error('id_user') is-invalid @enderror"
                                                id="id_user" name="id_user">
                                                <option value="" disabled selected>Pilih Petugas</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('id_user', $inventory->id_user) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_user')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back</a>
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
