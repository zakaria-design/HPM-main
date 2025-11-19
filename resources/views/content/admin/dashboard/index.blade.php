<div>
    
      <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <h4 class="pl-3">
                Selamat Datang 🖐🖐 <span class="text-primary">{{ Auth::user()->name }}</span>
            </h4>

            <div class="container my-4">
                <div class="row g-3 pt-2">

                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="stat-card bg-primary bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                    <div class="text-start">
                        <div class="fw-bold" style="font-size: 1.3rem;">{{ $invCount }}</div>
                        <div class="fw-semibold" style="font-size: 1rem;">INV</div>
                    </div>
                    <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="fas fa-envelope-open-text" style="font-size: 1.3rem; color: #0d6efd;"></i>
                    </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="stat-card bg-success bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                    <div class="text-start">
                        <div class="fw-bold" style="font-size: 1.3rem;">{{ $sphCount }}</div>
                        <div class="fw-semibold" style="font-size: 1rem;">SPH</div>
                    </div>
                    <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="fas fa-envelope" style="font-size: 1.3rem; color: #198754;"></i>
                    </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="stat-card bg-warning bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                    <div class="text-start">
                        <div class="fw-bold" style="font-size: 1.3rem;">{{ $sktCount }}</div>
                        <div class="fw-semibold" style="font-size: 1rem;">SKT</div>
                    </div>
                    <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="fas fa-envelope-square" style="font-size: 1.3rem; color: #ffb007;"></i>
                    </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="stat-card bg-danger bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                    <div class="text-start">
                        <div class="fw-bold" style="font-size: 1.3rem;">{{ $gagal }}</div>
                        <div class="fw-semibold" style="font-size: 1rem;">SPH Gagal</div>
                    </div>
                    <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.3rem; color: #dc3545;"></i>
                    </div>
                    </div>
                </div>

                </div>
            </div>
        </section>

            <section class="content-header">
            <div>
                <div class="d-flex justify-content-between mb-3 pl-4">
                    <h5>Daftar Pengajuan Hari ini </h5>
                </div>
                <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor Surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis Surat</th>
                            <th><i class="fas fa-user-tag mr-1 text-primary"></i> User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allToday as $index => $item)
                            <tr>
                                <td class="ps-5 small">{{ $index + 1 }}</td>
                                <td class="small">{{ $item->nomor_surat }}</td>
                                <td class="small">{{ $item->nama_customer }}</td>
                                <td class="small">{{ $item->jenis_surat }}</td>
                                <td class="small">{{ $item->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pengajuan surat hari ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </section>

     </div>

</div>
