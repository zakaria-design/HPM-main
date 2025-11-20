<div>

<div id="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">

                <!-- Title -->
                <div class="col-sm-6">
                    <h3 class="text-primary">
                        <i class="fas fa-envelope-open-text"></i> @yield('title')
                    </h3>
                </div>

                <!-- Breadcrumb -->
                <div class="col-sm-6 d-flex justify-content-sm-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i class="fas fa-user"></i> User
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-envelope-open-text"></i> @yield('title')
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </section>



    <!-- section tabel pengeluaran -->
    <section class="content">
        <div>
      <!-- Default box -->
      <div>
        <div>
            <div class="d-flex ps-2 mb-4">
            <!-- Tombol buka modal -->
                <!-- Button -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSurat">
                    <i class="fas fa-plus"></i> Ajukan Surat
                </button>
            </div>
        </div>
        {{-- card --}}
        <div class="card-body">
            {{-- table --}}
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis Surat</th>
                            <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                            <th><i class="fas fa-clock mr-1 text-primary"></i> Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuanHariIni as $p)
                            <tr>
                                <td class="ps-4 small">{{ $loop->iteration }}</td>
                                <td class="small">{{ $p->nomor_surat }}</td>
                                <td class="small">{{ $p->nama_customer }}</td>
                                <td class="small fw-bold">
                                    @foreach(explode(',', $p->jenis) as $jenis)
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
                                <td class="small">
                                    @if (!is_null($p->nominal) && $p->nominal !== '')
                                        Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="small">{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('H.i') }} WIB</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada pengajuan hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
      </div>  
    </section>
         

     {{-- create modal --}}
    @include('content.manager.pengajuan.surat')


    </div>
</div>

    
   