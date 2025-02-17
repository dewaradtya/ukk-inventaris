@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Pengaturan Denda</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('fine.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Denda Per Hari (Rp)</label>
                                    <input type="number" name="late_fee" class="form-control"
                                        value="{{ $fineSetting->late_fee }}" required>
                                    @error('late_fee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Denda Kehilangan Barang (Rp)</label>
                                    <input type="number" name="lost_fee" class="form-control"
                                        value="{{ $fineSetting->lost_fee }}" required>
                                    @error('lost_fee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
