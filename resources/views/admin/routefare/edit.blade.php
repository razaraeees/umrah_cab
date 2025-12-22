@extends('admin.layout')
@section('content')
        @livewire('admin.route-fares.route-edit', ['id' => $id])
@endsection