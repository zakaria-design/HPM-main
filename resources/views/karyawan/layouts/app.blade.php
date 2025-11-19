<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HPM | @yield('title')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])






    @include('karyawan.layouts.script')
      <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- semua link --}}
    @include('karyawan.layouts.style')

    @livewireStyles
  
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">


<div class="wrapper">
<!-- Navbar -->
    @include('karyawan.layouts.navbar')

<!-- Sidebar -->
    @include('karyawan.layouts.sidebar')

<!-- Content  -->
    @yield('content')

{{-- footer --}}
    @include('karyawan.layouts.footer')

</div>

<!-- jQuery -->


    @livewireScripts

</body>
</html>
