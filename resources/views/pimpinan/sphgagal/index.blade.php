@extends('pimpinan.layouts.app')

@section('title','Surat Gagal')
{{-- menu yg active --}}
@section('menuPimpinanSphGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.pimpinan.sphgagal.index')
@endsection
