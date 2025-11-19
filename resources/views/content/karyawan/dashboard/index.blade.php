<div>
    
    <div class="content-wrapper">
        <section class="content-header">
            <h3 class="mr-4">Selamat datang 🖐🖐 <span class="text-primary">{{ Auth::user()->name }}</span> </h3>
            <div class="container my-4">
            <div class="row g-3">
                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-primary bg-opacity-75 text-dark p-3 rounded d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                    <div class="fw-bold" style="font-size: 1.5rem;">{{ $totalSurat }}</div>
                    <div class="fw-semibold" style="font-size: 1rem;">Jumlah Surat</div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center bg-white rounded-circle" style="width: 50px; height: 50px;">
                    <i class="fas fa-mail-bulk" style="font-size: 1.5rem; color: #0d6efd;"></i>
                    </div>
                </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-success bg-opacity-75 text-dark p-3 rounded d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                    <div class="fw-bold" style="font-size: 1.5rem;">{{ $totalCustomers }}</div>
                    <div class="fw-semibold" style="font-size: 1rem;">Clients</div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center bg-white rounded-circle" style="width: 50px; height: 50px;">
                    <i class="fas fa-users" style="font-size: 1.5rem; color: #198754;"></i>
                    </div>
                </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-warning bg-opacity-75 text-dark p-3 rounded d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                    <div class="fw-bold" style="font-size: 1.5rem;">{{ $totalProgres }}</div>
                    <div class="fw-semibold" style="font-size: 0.9rem;">SPH Progres</div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center bg-white rounded-circle" style="width: 50px; height: 50px;">
                    <i class="fas fa-history" style="font-size: 1.5rem; color: #ffc107;"></i>
                    </div>
                </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-danger bg-opacity-75 text-dark p-3 rounded d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                    <div class="fw-bold" style="font-size: 1.5rem;">{{ $totalSphGagal }}</div>
                    <div class="fw-semibold" style="font-size: 0.9rem;">SPH Gagal</div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center bg-white rounded-circle" style="width: 50px; height: 50px;">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.5rem; color: #dc3545;"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </div>

</div>
