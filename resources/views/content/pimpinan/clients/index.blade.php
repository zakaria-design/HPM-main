<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">

                    <!-- Title -->
                    <div class="col-sm-6">
                        <h4 class="text-primary">
                            <i class="fas fa-users ps-3"></i> @yield('title')
                        </h4>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-sm-6 d-flex justify-content-sm-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-user-tie ps-3"></i> Pimpinan
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-users"></i> @yield('title')
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </section>


          <section class="content-header">
            <div>
                <div class=" mb-3 ml-3 col-10 col-md-4 ps-4">
                        <form action="" method="GET" class="input-group">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="cari nama customer..." 
                                class="form-control"
                                autocomplete="off">

                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                <div class="table-responsive">
                 <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-envelope mr-1 text-primary"></i> Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($uniqueCustomers as $index => $client)
                            <tr>
                                <td class="ps-5 small">{{ $index + 1 }}</td>
                                <td class="small">{{ $client->nama_customer }}</td>
                                <td class="small fw-bold">
                                    @foreach(explode(',', $client->jenis) as $jenis)
                                        @php 
                                            $jenis = trim($jenis); 
                                            $color = match($jenis) {
                                                'SPH' => 'text-success',   // hijau
                                                'SKT' => 'text-danger',    // merah
                                                'INV' => 'text-warning',   // kuning
                                                default => 'text-secondary'
                                            };
                                        @endphp
                                        
                                        <span class="{{ $color }}">{{ $jenis }}</span>
                                        @if(!$loop->last), @endif
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
                     {{-- {{ $clients->links('vendor.pagination.dots') }} --}}
                </div>
            </div>
        </section>


     </div>
</div>
