<div>  
    <div id="content-wrapper" class="mb-5">
        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="bg-white p-4 rounded shadow-sm">
                <section class="content-header">
            <h4 class="mr-4 pl-2">
                Welcome 🖐🖐 <span class="text-primary">{{ Auth::user()->name }}</span>
            </h4>
        </section>

        <div class="container my-4">
            <div class="row g-3">

            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-primary bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                <div class="text-start">
                    <div class="fw-bold" style="font-size: 1.3rem;">{{ $uniqueClientCount }}</div>
                    <div class="fw-semibold" style="font-size: 1rem;">Jumlah Client</div>
                </div>
                <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                    <i class="bi bi-people-fill" style="font-size: 1.3rem; color: #0d6efd;"></i>
                </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-success bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                <div class="text-start">
                    <div class="fw-bold" style="font-size: 1.3rem;">{{ $totalUserCount }}</div>
                    <div class="fw-semibold" style="font-size: 1rem;">Karyawan</div>
                </div>
                <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                    <i class="bi bi-person-check-fill" style="font-size: 1.3rem; color: #198754;"></i>
                </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="stat-card bg-warning bg-opacity-75 text-dark rounded d-flex align-items-center justify-content-between px-3" style="height:90px;">
                <div class="text-start">
                    <div class="fw-bold" style="font-size: 1.3rem;">{{ $totalSurat }}</div>
                    <div class="fw-semibold" style="font-size: 1rem;">Total Surat</div>
                </div>
                <div class="icon-wrapper d-flex justify-content-center align-items-center bg-white rounded-circle flex-shrink-0" style="width: 45px; height: 45px;">
                    <i class="fas fa-envelope" style="font-size: 1.3rem; color: #ffb007;"></i>
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
            <div class="card shadow-sm">
                <div class="card-header bg-info text-dark text-center bg-opacity-75">
                    <h5 class="mb-0 text-dark">Grafik Pengajuan Surat per Bulan</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="suratBarChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        </div>
    </div>
</div>

<script>
const suratBarChart = new Chart(document.getElementById('suratBarChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            { label: 'INV', data: @json($invMonthly), backgroundColor: 'rgba(54, 162, 235, 0.7)' },
            { label: 'SKT', data: @json($sktMonthly), backgroundColor: 'rgba(75, 192, 192, 0.7)' },
            { label: 'SPH', data: @json($sphMonthly), backgroundColor: 'rgba(255, 206, 86, 0.7)' }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            x: { stacked: false, beginAtZero: true },
            y: { stacked: false, beginAtZero: true }
        }
    }
});
</script>

