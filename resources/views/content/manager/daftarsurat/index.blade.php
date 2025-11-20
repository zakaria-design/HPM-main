<div>
<div id="content-wrapper" class="mb-5">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">

                <!-- Title -->
                <div class="col-sm-6">
                    <h3 class="text-primary">
                        <i class="fas fa-mail-bulk"></i> @yield('title')
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
                                <i class="fas fa-mail-bulk"></i> @yield('title')
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        <div>
      <!-- Default box -->
      <div>
        <div>

        </div>
        {{-- card --}}
        <div class="card-body">
            <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 px-3">

            {{-- KIRI: Filter + dropdown --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 w-100">

                <span class="fw-bold">Filter:</span>

                {{-- Dropdown Jenis Surat --}}
                <form method="GET" action="" class="w-100 w-md-auto">
                    <select name="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="SPH" {{ $jenis == 'SPH' ? 'selected' : '' }}>Surat Penawaran Harga</option>
                        <option value="INV" {{ $jenis == 'INV' ? 'selected' : '' }}>Surat Invoice</option>
                        <option value="SKT" {{ $jenis == 'SKT' ? 'selected' : '' }}>Surat Keterangan</option>
                    </select>
                </form>

                {{-- Dropdown Kategori --}}
                <form method="GET" action="" class="w-100 w-md-auto">
                    <select name="kategori" class="form-select" onchange="this.form.submit()">
                        <option value="semua" {{ ($kategori ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="perusahaan" {{ ($kategori ?? '') == 'perusahaan' ? 'selected' : '' }}>Surat Perusahaan</option>
                        <option value="perorangan" {{ ($kategori ?? '') == 'perorangan' ? 'selected' : '' }}>Surat Perorangan</option>
                    </select>
                </form>

            </div>

            {{-- KANAN: Pencarian --}}
            <div class="w-100 w-md-25">
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

        </div>

            {{-- table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor surat</th>
                                <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                                <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis Surat</th>
                                <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                                <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat as $p)
                                <tr>
                                    <td class="ps-4 small">{{ $loop->iteration + ($surat->currentPage()-1) * $surat->perPage() }}</td>
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
                                        @if($p->nominal)
                                            Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="small">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada surat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                  <!-- Pagination -->
                <div class="mt-3">
                    {{ $surat->links() }}
                </div>
            </div>    
        </div>
      </div>  
    </section>
         




    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
