@extends('pimpinan.layouts.app')

@section('title','Sph Progres')
{{-- menu yg active --}}
@section('menuPimpinanSphProgres','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('pimpinan.sphprogres.index')
@endsection
