<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class="fas fa-check-circle"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-tie"></i> Pimpinan</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-check-circle"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>


          <section class="content-header">          
            <div>
                <div class="d-flex justify-content-between mb-3 pl-4">
                    <input wire:model.live="search" type="text" class="form-control w-25" placeholder="Cari Customer...">
                </div>
                <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor Surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                            <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="ps-5 small">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                                <td class="small">{{ $item->nomor_surat }}</td>
                                <td class="small">{{ $item->nama_customer }}</td>
                                <td class="small">Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" 
                                        wire:click="showDetailSuccess({{ $item->id }})" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detailModal">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="mt-2">
                    {{ $data->links() }}
                </div>
            </div>
        </section>

        @include('livewire.pimpinan.sphsuccess.modal')
        @script
        <script>
            Livewire.on('showDetailModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            });
        </script>
        @endscript


     </div>
</div>
