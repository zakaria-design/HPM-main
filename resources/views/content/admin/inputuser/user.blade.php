{{-- Modal Tambah User --}}
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Form Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.inputuser.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Foto (Opsional/boleh kosong)</label>
                                <input type="file" name="foto" class="form-control">
                                <small class="text-muted">Format: jpg, jpeg, png | Maks 2MB</small>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary small btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary small btn-sm">Simpan User</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>