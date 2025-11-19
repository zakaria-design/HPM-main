@extends('pimpinan.layouts.app')

@section('title','Sph Success')
{{-- menu yg active --}}
@section('menuPimpinanSphSuccess','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('pimpinan.sphsuccess.index')
@endsection
