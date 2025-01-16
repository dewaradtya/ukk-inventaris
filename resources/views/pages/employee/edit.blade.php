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
                            
                                <div class="mb-3">
                                    <label for="name" class="form-label">Pegawai Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ old('name', $employee->name) }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="nip" class="form-label">Pegawai NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" 
                                        value="{{ old('nip', $employee->nip) }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="address" class="form-label">Pegawai Alamat</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $employee->address) }}</textarea>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
