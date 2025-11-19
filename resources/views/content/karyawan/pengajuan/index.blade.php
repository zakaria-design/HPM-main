<div>
    {{-- <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <!-- Judul dashboard -->
        <div class="row mb-3">
          <div class="col-12">
            <h1 class="m-0"> @yield('title')</h1>
          </div>
        </div>
    </div>
</section> --}}

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-primary"><i class="fas fa-envelope-open-text"></i> @yield('title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i> User</a></li>
              <li class="breadcrumb-item active"><i class="fas fa-envelope-open-text"></i> @yield('title')</li>
            </ol>
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
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pengajuanModal">
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
                        @forelse ($dataHariIni as $i => $item)
                            <tr>
                                <td class="ps-4">{{ $i + 1 }}</td>
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
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted p-3">
                                    Belum ada pengajuan hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
      </div>  
    </section>
         

     {{-- create modal --}}
    @include('livewire.karyawan.pengajuan.surat')

   @script
    <script>
        // Tutup modal setelah simpan
        $wire.on('closeModal', () => {
            $('#pengajuanModal').modal('hide');
        });

        // SweetAlert feedback
        $wire.on('showSuccess', data => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                showConfirmButton: true, 
                allowOutsideClick: true, 
            });
        });

        Livewire.on('showError', (data) => {
            Swal.fire({
                icon: 'error',
                title: 'gagall!',
                text: data.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                showConfirmButton: true, 
                allowOutsideClick: true, 
            });
        });

        // 💰 Format nominal otomatis pakai titik ribuan
        document.addEventListener('input', function(e) {
            if (e.target.id === 'nominalInput') {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = new Intl.NumberFormat('id-ID').format(value);
                $wire.set('nominal', e.target.value);
            }
        });
    </script>
    @endscript


    </div>
</div>

    
   