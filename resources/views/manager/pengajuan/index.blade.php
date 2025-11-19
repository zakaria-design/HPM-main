@extends('manager.layouts.app')

@section('title','Pengajuan Surat')
{{-- menu yg active --}}
@section('menuManagerPengajuan','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.manager.pengajuan.index')
@endsection
