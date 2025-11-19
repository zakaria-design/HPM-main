@extends('admin.layouts.app')

@section('title','Daftar Surat')
{{-- menu yg active --}}
@section('menuAdminDaftarSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.daftarsurat.index')
@endsection

