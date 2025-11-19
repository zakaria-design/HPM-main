<!-- Modal -->
    <div wire:ignore.self class="modal fade" id="pengajuanModal" tabindex="-1" role="dialog" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Form Pengajuan Surat</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" wire:model.defer="nama_customer" class="form-control" placeholder="Masukkan nama customer">
                            @error('nama_customer') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Surat</label>
                            <select wire:model="jenis_surat" class="form-control">
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="surat penawaran harga">Surat Penawaran Harga</option>
                                <option value="surat invoice">Surat Invoice</option>
                                <option value="surat keterangan">Surat Keterangan</option>
                            </select>
                            @error('jenis_surat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" 
                                   id="nominalInput"
                                   wire:model.defer="nominal"
                                   class="form-control"
                                   placeholder="Masukkan nominal"
                                   @if($jenis_surat === 'surat keterangan') disabled @endif>
                            @error('nominal') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>