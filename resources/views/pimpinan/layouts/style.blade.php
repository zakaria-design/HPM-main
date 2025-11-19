<!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}"> --}}

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

   {{-- link card --}}
<style>
        .stat-card {
          color: #fff;
          border-radius: 14px;
          padding: 16px;
          height: 100%;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stat-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }
        .stat-icon {
          width: 48px;
          height: 48px;
          background: #fff;
          color: #333;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 10px;
          font-size: 24px;
          margin-bottom: 10px;
        }
        .stat-number {
          font-size: 32px;
          font-weight: 700;
          line-height: 1.1;
        }
        .stat-subtitle {
          font-size: 0.9rem;
          font-weight: 500;
          opacity: 0.9;
        }
</style>
<style>
      .stat-card {
      display: flex !important;
      flex-direction: row !important;
      align-items: center !important;
      justify-content: space-between !important;
      padding: 1rem !important;
      border-radius: 0.5rem !important;
      height: 90px !important;
      overflow: hidden;
    }

    .stat-card .rounded-circle {
      flex-shrink: 0;
    }

    .stat-card i {
      display: inline-block;
      line-height: 1;
    }
</style>

{{-- diagram --}}
<style>
      .chart-container {
        width: 100%;
        max-width: 800px; /* ukuran tetap desktop */
        margin: 0 auto;
        height: 400px; /* tinggi default desktop */
    }

    /* Saat mobile (max-width 768px) */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px; /* lebih kecil di mobile */
        }
    }

</style>

{{-- dark mode --}}
<style>
      #toggle-dark i.fa-sun { color: #ffc107; }
      #toggle-dark i.fa-moon { color: #adb5bd; }
      /* Tabel dark mode */
      .dark-mode table.data-table {
          background-color: #35323288; /* background hitam */
          color: #fff; /* tulisan putih */
          border: 1px solid #fff; /* garis tabel putih */
      }

      /* Tabel header */
      .dark-mode table.data-table thead th {
          background-color: #111; /* sedikit lebih gelap untuk header */
          color: #fff;
          border: 1px solid #fff;
      }

      /* Tabel body */
      .dark-mode table.data-table tbody td {
          background-color: #3a3636;
          color: #fff;
          border: 1px solid #fff;
      }

      /* Kolom pencarian DataTables (jika pakai DataTables) */
      .dark-mode .dataTables_filter input {
          background-color: #fff !important; /* kolom pencarian putih */
          color: #000 !important; /* teks hitam supaya terbaca */
          border: 1px solid #ccc;
      }

      /* Scroll bar opsional agar terlihat */
      .dark-mode table.data-table tbody {
          scrollbar-color: #fff #000; /* thumb color / track color */
      }

</style>

{{-- menu active --}}
<style>
    .nav-link.active {
    background-color: #f59d19 !important; /* hijau */
    color: #fff !important;
    }
</style>




