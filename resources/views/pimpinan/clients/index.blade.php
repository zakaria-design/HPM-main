@extends('pimpinan.layouts.app')

@section('title','Clients')
{{-- menu yg active --}}
@section('menuPimpinanClients','active')
{{-- memanggil livewire --}}
@section('content')
    @livewire('pimpinan.clients.index')
@endsection
