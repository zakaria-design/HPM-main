<div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-primary"><i class=" fas fa-mail-bulk"></i> @yield('title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i> User</a></li>
              <li class="breadcrumb-item active"><i class=" fas fa-mail-bulk"></i> @yield('title')</li>
            </ol>
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
            <div class="d-flex justify-content-end">
                <div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle mb-4" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-print mr-1"></i>  Cetak
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-success" href="#"><i class="fas fa-file-excel mr-1"></i> Excel</a>
                        <a class="dropdown-item text-danger" href="{{ route('daftarsurat.exportPdf', [
                                'search' => $search ?? '',
                                'kategori' => $kategori ?? 'semua',
                                'jenis' => $jenis ?? 'semua'
                                  ]) }}" 
                                  target="_blank" 
                                  class="btn btn-danger">
                              <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- card --}}
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
              {{-- dropdown jenis surat --}}
              <div class="col-md-3">
                  <select wire:model.live="jenis" class="form-select">
                      <option value="semua">Semua Jenis</option>
                      <option value="surat penawaran harga">Surat Penawaran Harga</option>
                      <option value="surat invoice">Surat Invoice</option>
                      <option value="surat keterangan">Surat Keterangan</option>
                  </select>
              </div>
              {{-- akhir --}}
                {{-- drop down paginate --}}
                <div class="col-md-4">
                    <select wire:model.live="kategori" class="form-select">
                        <option value="semua">Semua</option>
                        <option value="perusahaan">Surat Perusahaan</option>
                        <option value="perorangan">Surat Perorangan</option>
                    </select>
                </div>
                {{-- pencarian --}}
                <div class="col-4">
                    {{-- dummy --}}
                    <input type="text" style="display:none">
                    <input type="password" style="display:none">
                    {{-- dummy --}}
                    <input wire:model.live="search" type="text"   name="dont_autofill_this_chrome" id="fake_search" placeholder="cari nama customer..." class="form-control" autocomplete="new-password">
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
            @forelse ($dataSurat as $i => $item)
                <tr>
                    <td class="ps-4">{{ $dataSurat->firstItem() + $i }}</td>
                    <td>{{ $item->nomor_surat }}</td>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ ucwords($item->jenis_surat) }}</td>
                    <td>
                        @if($item->nominal)
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
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
                    {{ $dataSurat->links() }}
                </div>
            </div>    
        </div>
      </div>  
    </section>
         




    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
