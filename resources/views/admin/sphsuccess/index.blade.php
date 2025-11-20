@extends('admin.layouts.app')

@section('title','Sph Success')
{{-- menu yg active --}}
@section('menuAdminSphSuccess','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphsuccess.index')
@endsection

