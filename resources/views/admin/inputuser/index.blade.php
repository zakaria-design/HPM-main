
@extends('admin.layouts.app')

@section('title','Input User')
{{-- menu yg active --}}
@section('menuAdminInputUser','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.inputuser.index')
@endsection

