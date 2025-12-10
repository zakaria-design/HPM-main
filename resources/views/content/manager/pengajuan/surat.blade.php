<!-- Modal -->
<div class="modal fade mt-5" id="modalSurat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('manager.pengajuan.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- Nama customer --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" name="nama_customer"
                               class="form-control @error('nama_customer') is-invalid @enderror"
                               required>
                        @error('nama_customer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Jenis surat --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Surat</label>
                        <select name="jenis_surat" class="form-select" required>
                            <option value="">-- pilih --</option>
                            @foreach ($jenis_surat as $js)
                                <option value="{{ $js }}">{{ ucwords($js) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nominal --}}
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" name="nominal" id="nominalInput" class="form-control">
                    </div>

                    {{-- Nama marketing --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Marketing</label>
                        <input type="text" name="marketing"
                               class="form-control ">
                       
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
    // Format angka ribuan
    document.getElementById('nominalInput').addEventListener('input', function(e) {
        let angka = e.target.value.replace(/\D/g, '');
        e.target.value = new Intl.NumberFormat('id-ID').format(angka);
    });
</script>