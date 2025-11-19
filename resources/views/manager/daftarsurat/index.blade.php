
@extends('manager.layouts.app')

@section('title','Daftar Surat')
{{-- menu yg active --}}
@section('menuManagerDaftarSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.manager.daftarsurat.index')
@endsection

