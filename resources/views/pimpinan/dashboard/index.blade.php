@extends('pimpinan.layouts.app')

@section('title','Dashboard')
{{-- menu yg active --}}
@section('menuPimpinanDashboard','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('pimpinan.dashboard.index')
@endsection
