@extends('layout')

@section('title')
    How many people speak at City Council each year?
@stop

@section('meta_description')
    Last year {{ $speakers->get(\Carbon\Carbon::now()->subYear()->year) }} people spoke at Edmonton City Council or Committee meetings.
@stop

@section('content')
    <h1 style="margin-bottom:3rem;">How many people speak at City Council each year?</h1>



@stop

@section('scripts')
    <script src="/scripts/Chart.min.js"></script>
    <script>
    </script>
@stop
