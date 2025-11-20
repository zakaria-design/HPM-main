@extends('admin.layouts.app')

@section('title','Sph Gagal')
{{-- menu yg active --}}
@section('menuAdminSphGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphgagal.index')
@endsection

