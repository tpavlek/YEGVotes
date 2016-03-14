@extends('layout')

@section('title')
- List Meetings
@stop

@section('content')

<div class="whitecard">
    <h2>Meetings</h2>
    <p>
        Not every meeting contains recorded votes, some are just agendas, and some are incomplete based on the data
        provided so far by the city clerk. For your convenience, we've bolded all meetings in the past three months that
        contain votes.
    </p>
</div>

<div class="pure-g">
    @foreach ($meetings as $yearMonth => $meetingGroup)
        <div class="pure-u-1 pure-u-md-1-3">
            <h2>{{ \Carbon\Carbon::createFromFormat("Y-m", $yearMonth)->format("F Y") }}</h2>
            <div class="meetings-list">
                @foreach ($meetingGroup as $meeting)
                    <a href="{{ URL::route('meetings.show', $meeting->id) }}" @if (\Carbon\Carbon::now()->subMonths(3)->lt(\Carbon\Carbon::createFromFormat("Y-m", $yearMonth)) && $meeting->hasVotes()) style="font-weight:800;" @endif>
                        {{ $meeting->meeting_type }}
                    </a> <br />
                @endforeach
            </div>
        </div>
    @endforeach

</div>
@stop
