<div class="modal fade mt-5" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('manager.suratgagal.update') }}" method="POST" class="modal-content">
            @csrf

            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="jenis_surat" id="edit_jenis">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label>Nomor Surat (Tidak bisa diubah)</label>
                <input type="text" id="edit_nomor" class="form-control" disabled>

                <label class="mt-2">Nama Customer</label>
                <input type="text" name="nama_customer" id="edit_nama" class="form-control">

                <label class="mt-2">Nominal</label>
                <input type="text" name="nominal" id="edit_nominal" class="form-control">


                <label class="mt-2">Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="gagal">Gagal</option>
                    <option value="berhasil">Success</option>
                    <option value="">Proses</option>
                </select>

            </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm small" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm small">Simpan</button>
        </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('editModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;

        document.getElementById('edit_id').value      = button.getAttribute('data-id');
        document.getElementById('edit_jenis').value   = button.getAttribute('data-jenis');
        document.getElementById('edit_nomor').value   = button.getAttribute('data-nomor');

        document.getElementById('edit_nama').value    = button.getAttribute('data-nama');
        document.getElementById('edit_nominal').value = button.getAttribute('data-nominal');
        document.getElementById('edit_status').value  = button.getAttribute('data-status');
    });
</script>
<script>
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Format saat buka modal
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;

    let nominal = button.getAttribute('data-nominal');

    // format ribuan saat tampil
    document.getElementById('edit_nominal').value = formatRupiah(nominal);
});

// Format saat mengetik
document.getElementById('edit_nominal').addEventListener('input', function () {
    let angka = this.value.replace(/\./g, "");
    if (!isNaN(angka)) {
        this.value = formatRupiah(angka);
    }
});

// Saat submit, kembalikan ke angka asli
document.querySelector('#editModal form').addEventListener('submit', function () {
    let input = document.getElementById('edit_nominal');
    input.value = input.value.replace(/\./g, "");  // Hapus titik
});
</script>

