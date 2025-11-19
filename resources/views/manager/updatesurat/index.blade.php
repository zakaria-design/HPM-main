@extends('manager.layouts.app')

@section('title','Update Surat')
{{-- menu yg active --}}
@section('menuManagerUpdateSurat','active')
{{-- memanggil livewire --}}
@section('content')
    @include('content.manager.updatesurat.index')
@endsection
