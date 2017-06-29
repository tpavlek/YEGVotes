@extends('layout')

@section('title', "City Council Meetings -")

@section('content')

<div class="whitecard">
    <h2 class="header">Meetings</h2>
    <p>
        Not every meeting contains recorded votes, some are just agendas, and some are incomplete based on the data
        provided so far by the city clerk. For your convenience, we've bolded all meetings in the past three months that
        contain votes.
    </p>
</div>

<div class="meetings-listing">
    @foreach ($meetings as $yearMonth => $meetingGroup)
        <div class="card meetings-list">
            <div class="card-content blue white-text">
                <span class="card-title">{{ \Carbon\Carbon::createFromFormat("Y-m", $yearMonth)->format("F Y") }}</span>
            </div>
            <div class="card-content">
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
