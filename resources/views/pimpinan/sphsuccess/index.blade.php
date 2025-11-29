@extends('pimpinan.layouts.app')

@section('title','Surat Success')
{{-- menu yg active --}}
@section('menuPimpinanSphSuccess','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.pimpinan.sphsuccess.index')
@endsection
