<!-- Modal Bootstrap 5 -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailModalLabel">Detail SPH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <table class="table table-borderless align-middle">
            <tr>
                <th class="text-start">Nomor Surat</th>
                <td class="text-center" style="width: 10px;">:</td>
                <td class="text-start" id="modalNomorSurat"></td>
            </tr>
            <tr>
                <th class="text-start">Nama Customer</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalNamaCustomer"></td>
            </tr>
            <tr>
                <th class="text-start">Nominal</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalNominal"></td>
            </tr>
            <tr>
                <th class="text-start">Dibuat</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalCreatedAt"></td>
            </tr>
            <tr>
                <th class="text-start">Nama User</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalUserName"></td>
            </tr>
            <tr>
                <th class="text-start">Diupdate</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalUpdatedAt"></td>
            </tr>
            <tr>
                <th class="text-start">Status</th>
                <td class="text-center">:</td>
                <td class="text-start" id="modalStatus"></td>
            </tr>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm small" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
