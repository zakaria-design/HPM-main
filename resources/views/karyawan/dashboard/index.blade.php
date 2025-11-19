
@extends('karyawan.layouts.app')

@section('title','Dashboard')
{{-- menu yg active --}}
@section('menuKaryawanDashboard','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('karyawan.dashboard.index')
@endsection

