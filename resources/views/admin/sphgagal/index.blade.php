@extends('admin.layouts.app')

@section('title','Surat Gagal')
{{-- menu yg active --}}
@section('menuAdminSphGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphgagal.index')
@endsection

