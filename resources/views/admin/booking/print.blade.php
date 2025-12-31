@extends('admin.print_layout')

@section('print_content')
    @livewire('admin.booking.booking-print', ['filters' => $filters])
@endsection