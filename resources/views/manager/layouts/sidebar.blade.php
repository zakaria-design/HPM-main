

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
                <a 
                href="{{ route('manager.dashboard.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('manager.dashboard.*') ? 'active' : '' }}">
                    <i class='bx bx-home fs-4 me-2'></i>
                    <span class="hide-when-collapse" style="opacity: 0.8;">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a 
                href="{{ route('manager.pengajuan.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('manager.pengajuan.*') ? 'active' : '' }}">
                    <i class='bx  bx-send fs-4 me-2'></i>  
                    <span class="hide-when-collapse" style="opacity: 0.8;">Pengajuan Surat</span>
                </a>
            </li>

            <li class="nav-item">
                <a  
                href="{{ route('manager.daftarsurat.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('manager.daftarsurat.*') ? 'active' : '' }}">
                    <i class='bx  bx-envelope fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">Daftar Surat</span>
                </a>
            </li>

            <li class="nav-item">
                <a 
                href="{{ route('manager.updatesurat.index') }}"
                class="nav-link text-white d-flex align-items-center menu-link 
                {{ request()->routeIs('manager.updatesurat.*') ? 'active' : '' }}">
                    <i class='bx  bx-hourglass fs-4 me-2'    ></i> 
                    <span class="hide-when-collapse" style="opacity: 0.8;">Update Surat</span>
                </a>
            </li>
        </ul>
    </div>
           