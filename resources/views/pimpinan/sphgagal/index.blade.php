@extends('pimpinan.layouts.app')

@section('title','Sph Gagal')
{{-- menu yg active --}}
@section('menuPimpinanSphGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('pimpinan.sphgagal.index')
@endsection
