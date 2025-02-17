<div class="modal fade" id="createBorrowingModal" tabindex="-1" aria-labelledby="createBorrowingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="createBorrowingModalLabel">Tambah Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('borrowing.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('borrow_date') is-invalid @enderror"
                                    id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                                <label for="borrow_date">Tanggal Peminjaman</label>
                                @error('borrow_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="inventory-container">
                        <div class="inventory-item">
                            <div class="row g-3 align-items-end mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pilih Inventaris</label>
                                    <select name="id_inventories[]" class="form-control inventory-select" required>
                                        @foreach ($inventories as $inventory)
                                            <option value="{{ $inventory->id }}" data-stock="{{ $inventory->amount }}">
                                                {{ $inventory->name }} (Stok: {{ $inventory->amount }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="amount[]" class="form-control inventory-amount"
                                        min="1" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-inventory">
                                hapus
                            </button>
                        </div>
                    </div>


                    <button type="button" id="add-more-inventory" class="btn btn-sm btn-success">Tambah Inventaris
                    </button>

                    @if (Auth::check() && in_array(Auth::user()->level->name, ['Admin', 'Operator']))
                        <div class="form-floating mt-3">
                            <select name="id_employee" id="id_employee" class="form-control" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            <label for="id_employee">Pilih Pegawai</label>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-more-inventory').addEventListener('click', function() {
        let inventoryContainer = document.getElementById('inventory-container');
        let newInput = `
        <div class="inventory-item">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-6">
                    <label class="form-label">Pilih Inventaris</label>
                    <select name="id_inventories[]" class="form-control inventory-select" required>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}" data-stock="{{ $inventory->amount }}">
                                {{ $inventory->name }} (Stok: {{ $inventory->amount }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="amount[]" class="form-control inventory-amount" min="1" required>
                </div>
            </div>
                <button type="button" class="btn btn-danger btn-sm remove-inventory">
                    Hapus
                </button>
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
