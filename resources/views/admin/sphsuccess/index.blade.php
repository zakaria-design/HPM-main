@extends('admin.layouts.app')

@section('title','Surat Success')
{{-- menu yg active --}}
@section('menuAdminSphSuccess','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.sphsuccess.index')
@endsection

