<div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userModalLabel">Tambah User Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <form wire:submit.prevent="save">
                    <!-- Nama -->
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
                        @error('name') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
                        @error('email') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model.defer="alamat" rows="3"></textarea>
                        @error('alamat') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" wire:model.defer="no_hp">
                        @error('no_hp') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" wire:model.defer="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="manager">Manager</option>
                        </select>
                        @error('role') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model.defer="password">
                        @error('password') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" class="form-control" wire:model.defer="password_confirmation">
                    </div>
                </form>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" wire:click="save">Simpan</button>
            </div>
        </div>
    </div>
</div>
