@extends('layout')

@section('title', "When did $speaker talk to City Council? -")

@section('content')
    <h1>{{ $speaker }} spoke {{ $meetings->count() }} times to Council</h1>
    @foreach($meetings as $meeting)
        <div class="whitecard" style="display: inline-block;">
            <h2>{{ $meeting->title }}</h2>
            <a href="{{ URL::route('meetings.show', $meeting->id) }}" class="button"><i class="fa fa-arrow-right"></i> View Meeting</a>
        </div>
    @endforeach
@stop
