


<!-- Bootstrap JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- diagram --}}
<script>
    const ctx = document.getElementById('suratBarChart').getContext('2d');

    const suratBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                { label: 'INV', data: [12,19,10,5,8,15,20,14,7,9,11,16], backgroundColor: 'rgba(54, 162, 235, 0.7)' },
                { label: 'SKT', data: [7,11,5,8,12,6,14,10,4,9,7,5], backgroundColor: 'rgba(75, 192, 192, 0.7)' },
                { label: 'SPH', data: [3,5,8,2,6,4,7,3,2,4,5,3], backgroundColor: 'rgba(255, 206, 86, 0.7)' }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // biar ikut parent height
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                x: { stacked: false, beginAtZero: true },
                y: { stacked: false, 
            beginAtZero: true,
            ticks: {
                // ⬇️ ini yang menghapus .0
                callback: function(value) {
                    return Number.isInteger(value) ? value : null;
                },
                stepSize: 1 }
            }
        }
    });

</script>

{{-- dark mode --}}
<script>
        function applyDarkMode() {
            const body = document.body;
            const isDark = localStorage.getItem('dark-mode') === 'true';
            body.classList.toggle('dark-mode', isDark);

            const toggle = document.getElementById('toggle-dark');
            if (toggle) {
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-moon', !isDark);
                    icon.classList.toggle('fa-sun', isDark);
                }
            }
        }

        // Gunakan event delegation untuk tombol global
        document.addEventListener('click', function(e) {
            const toggle = e.target.closest('#toggle-dark');
            if (!toggle) return;

            e.preventDefault();
            const body = document.body;
            const currentlyDark = body.classList.contains('dark-mode');
            body.classList.toggle('dark-mode', !currentlyDark);
            localStorage.setItem('dark-mode', !currentlyDark);

            const icon = toggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-moon', currentlyDark);
                icon.classList.toggle('fa-sun', !currentlyDark);
            }
        });

        // Inisialisasi saat halaman pertama dimuat
        document.addEventListener('DOMContentLoaded', applyDarkMode);

        // Inisialisasi ulang setelah Livewire navigasi (setiap halaman baru)
        document.addEventListener('livewire:navigated', applyDarkMode);
</script>



