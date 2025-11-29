<div>
    <div id="content-wrapper">
            <!-- Content Header (Page header) -->
        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">

                    <!-- Title -->
                    <div class="col-sm-6">
                        <h3 class="text-primary">
                            <i class="fas fa-times-circle ps-2"></i> @yield('title')
                        </h3>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-sm-6 d-flex justify-content-sm-end ps-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-user"></i> User
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-times-circle"></i> @yield('title')
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </section>

         <section class="content">
            <div>
        <!-- Default box -->
        <div>
            {{-- card --}}
            <div>
                <div class="d-flex justify-content-between">
                {{-- dropdown jenis surat --}}
                <div class="col-12 ps-2">
                        <p class="text-l text-bold text-primary"><i class="far fa-calendar-times ps-3 mr-1"></i> Surat SPH dan INV yang gagal</p>
                </div>
                </div>
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
                                <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                                <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis</th>
                                <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Update</th>
                                <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $row)
                                <tr>
                                    <td class="ps-4 small">{{ $index+1 }}</td>
                                    <td class="small">{{ $row->nomor_surat }}</td>
                                    <td class="small">{{ $row->nama_customer }}</td>
                                    <td class="small"> 
                                        @if($row->nominal)
                                            Rp {{ number_format($row->nominal, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="small fw-bold">
                                        @foreach(explode(',', $row->jenis_surat) as $jenis)
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
                                    <td class="small">{{ \Carbon\Carbon::parse($row->updated_at)->format('d/m/Y') }}</td>                                  
                                    <td>
                                        <button class="btn btn-outline-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-id="{{ $row->id }}"
                                                data-jenis="{{ $row->jenis_surat }}"
                                                data-nomor="{{ $row->nomor_surat }}"
                                                data-nama="{{ $row->nama_customer }}"
                                                data-nominal="{{ $row->nominal }}"
                                                data-status="{{ $row->status }}"
                                                title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <span> | </span>
                                        <form action="{{ route('manager.suratgagal.delete') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $row->id }}">
                                            <input type="hidden" name="jenis_surat" value="{{ $row->jenis_surat }}">
                                            <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin hapus data?')"
                                             title="Hapus Data">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
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
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>

                </div>    
            </div>
        </div>  
    </section>

    </div>
</div>

@include('content.manager.suratgagal.modal')