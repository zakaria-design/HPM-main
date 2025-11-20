@extends('admin.layouts.app')

@section('title','Sph In Progres')
{{-- menu yg active --}}
@section('menuAdminSphProgres','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphprogres.index')
@endsection

