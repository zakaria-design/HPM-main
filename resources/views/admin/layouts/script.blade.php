




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





