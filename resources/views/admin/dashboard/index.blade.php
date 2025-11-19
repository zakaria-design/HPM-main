
@extends('admin.layouts.app')

@section('title','Dashboard')
{{-- menu yg active --}}
@section('menuAdminDashboard','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('admin.dashboard.index')
@endsection

