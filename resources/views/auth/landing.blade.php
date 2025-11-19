<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HERITAGE PIJAR MANAJEMEN</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center overflow-hidden">

  <!-- Container Landing Page -->
  <div id="landing" class="flex flex-col md:flex-row w-full min-h-screen">

    <!-- Kiri: Teks dan Button dengan Gradasi -->
    <div class="flex-1 flex flex-col justify-center items-start md:items-start px-6 md:px-16 z-10
                bg-gradient-to-r from-orange-600 to-black animate-fadeIn">
      <!-- Judul -->
      <h1 class="text-3xl sm:text-4xl md:text-7xl font-bold text-white mb-6 drop-shadow-lg text-center md:text-left">
        HERITAGE PIJAR MANAJEMEN
      </h1>

      <!-- Paragraf -->
      <p class="text-base sm:text-lg md:text-xl text-white mb-10 max-w-md drop-shadow-md text-center md:text-left">
        kami membantu membangun profesional bersertifikat dan badan usaha terpercaya, 
        dengan solusi inovatif yang mendukung pertumbuhan bisnis berkelanjutan.
      </p>

      <!-- Button -->
      <div class="w-full flex justify-center md:justify-start">
        <a href="{{ route('login') }}" 
           id="startButton"
           class="inline-block bg-white text-black font-semibold px-8 py-3 rounded-lg shadow-lg transform transition duration-300 hover:scale-105 hover:bg-orange-500 hover:text-white active:scale-95">
          Start
        </a>
      </div>
    </div>

    <!-- Kanan: Gambar dengan Overlay Hitam dan Animasi sama dengan teks -->
    <div class="flex-1 relative hidden md:block animate-fadeIn">
      <img src="{{ asset('landing/landing3.jpg') }}" 
           alt="Business Image" 
           class="w-full h-full object-cover">
      <!-- Overlay Gradasi Hitam di kiri, pas di perbatasan dengan kolom teks -->
      <div class="absolute inset-y-0 left-0 w-1/4 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
    </div>

  </div>

  <!-- Animasi fade-in / fade-out -->
  <style>
    /* Fade-in teks dan gambar */
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* Fade-out untuk transisi keluar */
    @keyframes fadeOut {
      0% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(20px); }
    }

    .animate-fadeIn { animation: fadeIn 1.2s ease-out forwards; }
    .animate-fadeOut { animation: fadeOut 0.8s ease-in forwards; }
  </style>

  <script>
    const button = document.getElementById('startButton');
    const landing = document.getElementById('landing');

    button.addEventListener('click', function(event) {
      event.preventDefault(); 
      landing.classList.add('animate-fadeOut'); 

      setTimeout(() => {
        window.location.href = button.href;
      }, 800); 
    });
  </script>

</body>
</html>
