
@extends('karyawan.layouts.app')

@section('title','Daftar Surat')
{{-- menu yg active --}}
@section('menuKaryawanDaftarSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('karyawan.daftarsurat.index')
@endsection

