<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class="fas fa-users"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-tie"></i> Pimpinan</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-users"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>

          <section class="content-header">
            <div>
                <div class="d-flex justify-content-between mb-3 pl-3">
                    <input wire:model.live="search" type="text" class="form-control w-25" placeholder="Cari Customer...">
                </div>
                <div class="table-responsive">
                 <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-envelope mr-1 text-primary"></i>Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $i => $client)
                            <tr>
                                <td class="ps-5 small">{{ $i + 1 }}</td>
                                <td class="small">{{ $client['nama_customer'] }}</td>
                                <td class="small">
                                    @foreach($client['jenis_surat'] as $jenis)
                                        <span class="badge badge-info mr-1">{{ $jenis }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                     {{ $clients->links('vendor.pagination.dots') }}
                </div>
            </div>
        </section>


     </div>
</div>
