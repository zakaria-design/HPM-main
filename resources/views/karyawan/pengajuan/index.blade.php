@extends('karyawan.layouts.app')

@section('title','Pengajuan Surat')
{{-- menu yg active --}}
@section('menuKaryawanPengajuan','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('karyawan.pengajuan.index')
@endsection
