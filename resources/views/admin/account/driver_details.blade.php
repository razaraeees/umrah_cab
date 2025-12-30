@extends('admin.layout')
@section('content')
    @livewire('admin.accounts.driver-details', ['id' => $id ])
@endsection
