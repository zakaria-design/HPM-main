<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HPM | @yield('title')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
      
        <!-- Bootstrap 5 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Font Awesome 5 Free -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.5/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKB4Imkb9aI6/6eB7f/7uCvzF9lOzDqY0h+0Bkfj1T8m0LZB4n9Z6cIxh+WxuJ4iN0B2kz5+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            overflow-x: hidden;
            background: #f5f5f5;
        }

        /*****************************
         *     SIDEBAR FULL SIZE
         *****************************/
        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #1e1e1e;
            color: white;
            padding-top: 35px; /* agar konten turun sejajar navbar */
            padding-left: 15px;
            padding-right: 15px;
            transition: 0.3s;
            z-index: 1000;
        }


        /***** Sidebar Collapse *****/
        #sidebar.collapsed {
            width: 70px;
        }

        #sidebar.collapsed .hide-when-collapse {
            display: none !important;
        }

        /* Hover */
        #sidebar .nav-link:hover {
            background: #ff9800 !important;
            color: #fff !important;
        }

        /* Active normal mode */
        #sidebar .nav-link.active {
            background: #e65100 !important;
            color: #fff !important;
        }

        /* Active collapse mode → hanya icon */
        #sidebar.collapsed .nav-link.active {
            background: transparent !important;
            color: #ff9800 !important;
        }

        #sidebar.collapsed .nav-link.active i {
            color: #ff9800 !important;
        }

        /*****************************
         *          NAVBAR
         *****************************/
        .navbar-custom {
            height: 60px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: calc(100% - 250px);
            margin-left: 250px;
            z-index: 2000;
            transition: 0.3s;
        }

        /* Saat sidebar collapse */
        #sidebar.collapsed ~ .navbar-custom {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        /*****************************
         *        CONTENT WRAPPER
         *****************************/
        #sidebar.collapsed ~ div #content-wrapper {
            margin-left: 80px;
        }

        div #content-wrapper {
            margin-left: 250px;
            transition: 0.3s ease;
        }

        

        /*****************************
         *         MOBILE MODE
         *****************************/
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                top: 60px;
                width: 250px;
            }
            #sidebar.show {
                transform: translateX(0);
            }

            .navbar-custom {
                margin-left: 0 !important;
                width: 100% !important;
            }

            #content-wrapper {
                margin-left: 0 !important;
                padding-top: 90px;
            }
            body {
                font-size: 0.875rem; /* 14px */
            }
        }

        .sidebar-photo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .navbar-photo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid black;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
  
  <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- semua link --}}
    @include('admin.layouts.style')

    @livewireStyles
  
</head>
<body>

<!-- Sidebar -->
    @include('admin.layouts.sidebar')

<!-- Navbar -->
    @include('admin.layouts.navbar')
     
<!-- Content  -->
    @yield('content')

{{-- footer --}}
    @include('admin.layouts.footer')

    @livewireScripts

<script>
        document.addEventListener('livewire:navigated', sidebarInit);
        document.addEventListener('DOMContentLoaded', sidebarInit);

        function sidebarInit() {

            const sidebar = document.getElementById("sidebar");
            const toggleSidebar = document.getElementById("toggleSidebar");
            const toggleMobileSidebar = document.getElementById("toggleMobileSidebar");

            if (toggleSidebar) {
                toggleSidebar.onclick = () => {
                    sidebar.classList.toggle("collapsed");
                };
            }

            if (toggleMobileSidebar) {
                toggleMobileSidebar.onclick = () => {
                    sidebar.classList.toggle("show");
                };
            }
        }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
