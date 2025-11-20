@extends('pimpinan.layouts.app')

@section('title','Daftar Surat')
{{-- menu yg active --}}
@section('menuPimpinanDaftarSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.pimpinan.daftarsurat.index')
@endsection
