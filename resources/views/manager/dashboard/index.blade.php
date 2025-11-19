
@extends('manager.layouts.app')

@section('title','Dashboard')
{{-- menu yg active --}}
@section('menuManagerDashboard','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.manager.dashboard.index')
@endsection

