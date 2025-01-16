@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Edit Jenis Inventaris</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('type.update', $type->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                            
                                <div class="mb-3">
                                    <label for="name" class="form-label">Jenis Inventaris Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ old('name', $type->name) }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="code" class="form-label">Jenis Inventaris Kode</label>
                                    <input type="text" class="form-control" id="code" name="code" 
                                        value="{{ old('code', $type->code) }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="information" class="form-label">Jenis Inventaris Informasi</label>
                                    <textarea class="form-control" id="information" name="information" rows="3">{{ old('information', $type->information) }}</textarea>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('type.index') }}" class="btn btn-secondary">Back</a>
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
