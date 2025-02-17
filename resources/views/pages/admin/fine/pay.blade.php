<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="payModalLabel">Bayar Denda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="fineId" name="fine_id">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" id="employeeName" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Denda</label>
                                <input type="text" id="totalFine" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sudah Dibayar</label>
                                <input type="text" id="paidAmount" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sisa Pembayaran</label>
                            <input type="text" id="remainingAmount" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal Pembayaran</label>
                            <input type="number" id="paymentAmount" name="payment_amount" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control @error('payment_proof') is-invalid @enderror"
                                id="payment_proof" name="payment_proof">
                            <div class="mt-2">
                                <img id="previewImage" src="" alt="Bukti bayar"
                                    style="width: 100px; display: none;">
                            </div>
                            @error('payment_proof')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const payForm = document.getElementById("payForm");

        document.querySelectorAll(".open-pay-modal").forEach(button => {
            button.addEventListener("click", function() {
                const fineId = this.getAttribute("data-id");
                const employeeName = this.getAttribute("data-employee");
                const totalFine = this.getAttribute("data-total");
                const paidAmount = this.getAttribute("data-paid");
                const remainingAmount = this.getAttribute("data-remaining");

                document.getElementById("fineId").value = fineId;
                document.getElementById("employeeName").value = employeeName;
                document.getElementById("totalFine").value = totalFine;
                document.getElementById("paidAmount").value = paidAmount;
                document.getElementById("remainingAmount").value = remainingAmount;

                payForm.setAttribute("action", `/fine/${fineId}/pay`);
            });
        });
    });

    document.getElementById('payment_proof').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
</script>
