
@extends('admin.layouts.app')

@section('title','Dashboard')
{{-- menu yg active --}}
@section('menuAdminDashboard','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.admin.dashboard.index')
@endsection

