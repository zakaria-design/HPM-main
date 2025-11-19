@extends('admin.layouts.app')

@section('title','Sph In Progres')
{{-- menu yg active --}}
@section('menuAdminSphProgres','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.sphprogres.index')
@endsection

