@extends('layout')

@section('content')

<h2>Meetings</h2>

    @foreach ($meetings as $meeting)
        <a href="{{ URL::route('meetings.show', $meeting->id) }}">{{ $meeting->title }}</a> <br />
    @endforeach
@stop
