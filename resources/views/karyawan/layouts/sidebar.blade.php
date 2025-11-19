      <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('hpm-logo-2.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">HPM</span>
    </a>
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a wire:navigate href="{{ route('karyawan.dashboard.index') }}" class="nav-link  @yield('menuKaryawanDashboard')">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item ">
            <a wire:navigate href="{{ route('karyawan.pengajuan.index') }}" class="nav-link  @yield('menuKaryawanPengajuan')">
              <i class="nav-icon fas fa-envelope-open-text"></i>
              <p>
                Pengajuan Surat
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a wire:navigate href="{{ route('karyawan.daftarsurat.index') }}" class="nav-link @yield('menuKaryawanDaftarSurat')">
              <i class="nav-icon fas fa-mail-bulk"></i>
              <p>
                Daftar Surat
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a wire:navigate href="{{ route('karyawan.updatesurat.index') }}" class="nav-link  @yield('menuKaryawanUpdateSurat')">
              <i class="nav-icon fas fa-reply-all"></i>
              <p>
                Update Surat 
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
