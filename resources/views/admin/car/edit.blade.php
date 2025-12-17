@extends('admin.layout')
@section('content')
        @livewire('admin.car.edit', ['carId' => $id])
@endsection

