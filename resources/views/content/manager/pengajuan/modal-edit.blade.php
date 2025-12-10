<div class="modal fade mt-5" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formEdit" method="POST">
        @csrf
        
        <div class="modal-body">

            <input type="hidden" name="tabel" id="edit_tabel">

            <div class="mb-3">
                <label class="form-label">Nomor Surat</label>
                <input type="text" class="form-control" id="edit_nomor" name="nomor_surat" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Customer</label>
                <input type="text" class="form-control" id="edit_nama" name="nama_customer" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Marketing</label>
                <input type="text" class="form-control" id="edit_marketing" name="marketing" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nominal</label>
                <input type="text" class="form-control" id="edit_nominal" name="nominal">
            </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm small" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm small">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var editModal = document.getElementById('editModal');

    editModal.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget;

        var id      = button.getAttribute('data-id');
        var tabel   = button.getAttribute('data-tabel');
        var nomor   = button.getAttribute('data-nomor');
        var nama    = button.getAttribute('data-nama');
        var marketing    = button.getAttribute('data-marketing');
        var nominal = button.getAttribute('data-nominal');

        // Isi modal
        document.getElementById('edit_nomor').value = nomor;
        document.getElementById('edit_nama').value  = nama;
        document.getElementById('edit_marketing').value  = marketing;

        // Format nominal saat modal dibuka
        if (nominal) {
            document.getElementById('edit_nominal').value =
                new Intl.NumberFormat("id-ID").format(nominal);
        } else {
            document.getElementById('edit_nominal').value = '';
        }

        // Set action
        document.getElementById('formEdit').action =
            "/manager/pengajuan/update/" + tabel + "/" + id;
    });

});

// ==============================
// Format ribuan SAAT DIKETIK
// ==============================
document.addEventListener("input", function(e) {
    if (e.target.id === "edit_nominal") {
        let angka = e.target.value.replace(/[^0-9]/g, "");
        e.target.value = angka === "" ? "" : new Intl.NumberFormat("id-ID").format(angka);
    }
});
</script>
<script>
// Bersihkan format nominal sebelum form submit
document.getElementById('formEdit').addEventListener('submit', function (e) {
    let nominalInput = document.getElementById('edit_nominal');

    // Hapus semua titik
    nominalInput.value = nominalInput.value.replace(/\./g, '');
});
</script>
