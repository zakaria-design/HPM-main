@extends('admin.layouts.app')

@section('title','Sph Success')
{{-- menu yg active --}}
@section('menuAdminSphSuccess','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.sphsuccess.index')
@endsection

