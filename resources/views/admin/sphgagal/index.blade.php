@extends('admin.layouts.app')

@section('title','Sph Gagal')
{{-- menu yg active --}}
@section('menuAdminSphGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.sphgagal.index')
@endsection

