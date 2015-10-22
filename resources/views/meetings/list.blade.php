@extends('layout')

@section('title')
- List Meetings
@stop

@section('content')

<h2>Meetings</h2>
<div class="pure-g">

    @foreach ($meetings as $yearMonth => $meetingGroup)
        <div class="pure-u-1 pure-u-md-1-3">
            <h2>{{ \Carbon\Carbon::createFromFormat("Y-m", $yearMonth)->format("F Y") }}</h2>
            <div class="meetings-list">
                @foreach ($meetingGroup as $meeting)
                    <a href="{{ URL::route('meetings.show', $meeting->id) }}">{{ $meeting->meeting_type }}</a> <br />
                @endforeach
            </div>
        </div>
    @endforeach

</div>
@stop
