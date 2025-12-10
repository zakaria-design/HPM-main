<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.surat.update') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="jenis" id="editJenis">

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" name="nama_customer" id="editNama" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="editNomor" class="form-control" readonly>
                </div>

                <!-- Nominal (hanya untuk SPH dan INV) -->
                <div class="mb-3" id="wrapNominal">
                    <label class="form-label">Nominal</label>
                    <input type="text" name="nominal" id="editNominal" class="form-control">
                </div>

                <!-- Status (hanya untuk SPH dan INV) -->
                <div class="mb-3" id="wrapStatus">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="berhasil">Berhasil</option>
                        <option value="gagal">Gagal</option>
                        <option value="proses">Proses</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>

        </form>
    </div>
</div>


<script>
const modalEdit = document.getElementById('modalEdit');

// 🔹 Fungsi format angka → 3.000.000
        function formatRupiah(angka) {
            angka = angka.toString().split('.')[0];  // buang desimal seperti .00
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

modalEdit.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('editNama').value = button.getAttribute('data-nama');
    document.getElementById('editNomor').value = button.getAttribute('data-nomor');
    document.getElementById('editJenis').value = button.getAttribute('data-jenis');

    const jenis = button.getAttribute('data-jenis');

    // Nominal dan Status (hanya SPH & INV)
    if (jenis === 'SPH' || jenis === 'INV') {
        document.getElementById('wrapNominal').style.display = 'block';
        document.getElementById('wrapStatus').style.display = 'block';

        // ⬅️ TAMBAHAN: format nominal saat modal dibuka
        const nilaiNominal = button.getAttribute('data-nominal');
        document.getElementById('editNominal').value = formatRupiah(nilaiNominal);

        document.getElementById('editStatus').value = button.getAttribute('data-status');
    } else {
        document.getElementById('wrapNominal').style.display = 'none';
        document.getElementById('wrapStatus').style.display = 'none';
    }
});


// ⬅️ TAMBAHAN: format saat diketik
document.getElementById("editNominal").addEventListener("input", function () {
    let angka = this.value.replace(/\./g, ""); // bersihkan titik sebelum format ulang
    this.value = formatRupiah(angka);
});


// ⬅️ TAMBAHAN: sebelum form dikirim → ubah 3.000.000 menjadi 3000000
document.querySelector("#modalEdit form").addEventListener("submit", function () {
    let input = document.getElementById("editNominal");
    input.value = input.value.replace(/\./g, ""); 
});
</script>

