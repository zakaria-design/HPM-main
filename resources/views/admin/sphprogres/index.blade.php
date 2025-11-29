@extends('admin.layouts.app')

@section('title','Surat In Progres')
{{-- menu yg active --}}
@section('menuAdminSphProgres','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphprogres.index')
@endsection

