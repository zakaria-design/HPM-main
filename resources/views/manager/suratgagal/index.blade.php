@extends('manager.layouts.app')

@section('title','Surat Gagal')
{{-- menu yg active --}}
@section('menuManagerSuratGagal','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.manager.suratgagal.index')
@endsection
