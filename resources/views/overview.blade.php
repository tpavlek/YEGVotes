@extends('layout')

@section('title', "Track Edmonton City Councillors -")

@section('content')

    <div class="flex flex-wrap justify-center">
        @foreach ($attendance as $attendanceRecord)
            @include('councilMemberPartial', [ 'attendance_record' => $attendanceRecord ])
        @endforeach
    </div>
@stop

@section('scripts')

@stop
