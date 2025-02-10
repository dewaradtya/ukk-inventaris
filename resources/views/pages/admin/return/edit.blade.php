@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Edit Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('borrowing.update', $borrowing->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="borrow_date" class="form-label">Tanggal Peminjaman</label>
                                            <input type="date"
                                                class="form-control @error('borrow_date') is-invalid @enderror"
                                                id="borrow_date" name="borrow_date"
                                                value="{{ old('borrow_date', $borrowing->borrow_date) }}">
                                            @error('borrow_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                                            <input type="date"
                                                class="form-control @error('return_date') is-invalid @enderror"
                                                id="return_date" name="return_date"
                                                value="{{ old('return_date', $borrowing->return_date) }}">
                                            @error('return_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (auth()->user()->level->name !== 'Peminjam')
                                        <div class="mb-3">
                                            <label for="id_employee" class="form-label">Pegawai</label>
                                            <select class="form-control @error('id_employee') is-invalid @enderror"
                                                id="id_employee" name="id_employee">
                                                <option value="" disabled selected>Pilih Pegawai</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ old('id_employee', $borrowing->id_employee) == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} ({{ $employee->nip }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_employee')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div id="inventory-container">
                                        @foreach ($borrowing->loanDetails as $loanDetail)
                                            <div class="inventory-item">
                                                <div class="mb-3">
                                                    <label class="form-label">Pilih Inventaris</label>
                                                    <select name="id_inventories[]" class="form-control inventory-select"
                                                        required>
                                                        @foreach ($inventories as $inventory)
                                                            <option value="{{ $inventory->id }}"
                                                                data-stock="{{ $inventory->amount }}"
                                                                {{ $inventory->id == $loanDetail->id_inventories ? 'selected' : '' }}>
                                                                {{ $inventory->name }} (Stok:
                                                                {{ $inventory->amount }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah</label>
                                                    <input type="number" name="amount[]"
                                                        class="form-control inventory-amount" min="1"
                                                        value="{{ $loanDetail->amount }}" required>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-inventory">Hapus</button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" id="add-more-inventory" class="btn btn-sm btn-success">Tambah
                                        Inventaris</button>

                                    <div class="card-footer">
                                        <a href="{{ route('borrowing.index') }}" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('add-more-inventory').addEventListener('click', function() {
            let inventoryContainer = document.getElementById('inventory-container');
            let newInput = `
            <div class="inventory-item">
                <div class="mb-3">
                    <label class="form-label">Pilih Inventaris</label>
                    <select name="id_inventories[]" class="form-control inventory-select" required>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}" data-stock="{{ $inventory->amount }}">
                                {{ $inventory->name }} (Stok: {{ $inventory->amount }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="amount[]" class="form-control inventory-amount" min="1" required>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-inventory">Hapus</button>
            </div>
        `;
            inventoryContainer.insertAdjacentHTML('beforeend', newInput);
            addRemoveEvent();
        });

        function addRemoveEvent() {
            document.querySelectorAll('.remove-inventory').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.inventory-item').remove();
                });
            });

            document.querySelectorAll('.inventory-amount').forEach(input => {
                input.addEventListener('input', function() {
                    let maxStock = this.closest('.inventory-item').querySelector('.inventory-select')
                        .selectedOptions[0].getAttribute('data-stock');
                    if (parseInt(this.value) > parseInt(maxStock)) {
                        alert('Jumlah melebihi stok yang tersedia!');
                        this.value = maxStock;
                    }
                });
            });
        }

        addRemoveEvent();
    </script>
@endsection
