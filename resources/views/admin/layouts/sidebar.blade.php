
  

    <div id="sidebar">
<div class="d-flex align-items-center mb-4">
    <img src="{{ asset('hpm-logo-2.jpg') }}" 
        class="rounded-circle img-fluid" 
        style="width: 40px; height: 40px; object-fit: cover;" 
        alt="hppm">

    <h5 class="ml-2 hide-when-collapse" style="margin-top: 7px;">HPM</h5>
</div>
        <ul class="nav flex-column">

            <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.dashboard.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                    <i class='bx bx-home fs-4 me-2'></i>
                    <span class="hide-when-collapse" style="opacity: 0.8;">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.inputuser.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.inputuser.*') ? 'active' : '' }}">
                    <i class='bx bx-user fs-4 me-2'></i>
                    <span class="hide-when-collapse" style="opacity: 0.8;">Input User</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.daftarsurat.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.daftarsurat.*') ? 'active' : '' }}">
                    <i class='bx  bx-envelope fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">Daftar Surat</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.sphprogres.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.sphprogres.*') ? 'active' : '' }}">
                    <i class='bx  bx-hourglass fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">SPH In Progres</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.sphsuccess.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.sphsuccess.*') ? 'active' : '' }}">
                    <i class='bx  bx-check-circle fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">SPH Success</span>
                </a>
            </li>

                        <li class="nav-item">
                <a wire:navigate 
                href="{{ route('admin.sphgagal.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('admin.sphgagal.*') ? 'active' : '' }}">
                    <i class='bx  bx-x-circle fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">SPH Gagal</span>
                </a>
            </li>

        </ul>
    </div>

