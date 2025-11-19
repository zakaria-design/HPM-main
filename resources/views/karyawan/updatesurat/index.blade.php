@extends('karyawan.layouts.app')

@section('title','Update Surat')
{{-- menu yg active --}}
@section('menuKaryawanUpdateSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('karyawan.updatesurat.index')
@endsection
