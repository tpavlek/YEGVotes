@extends('layout')

@section('title', "City Council Meetings -")

@section('content')

<div class="bg-blue-lighter text-blue-darkest rounded-b shadow-md border-t-4 border-blue-darker p-4 m-2 max-w-md flex mx-auto leading-normal" role="alert">
    <div class="text-3xl mr-4 flex flex-col">
        <i class="fas fa-info-circle flex-grow"></i>
    </div>
    <div>
        <p>
            Not every meeting contains recorded votes, some are just agendas, and some are incomplete based on the data
            provided so far by the city clerk.
        </p>
        <p>
            Meetings that contain votes are bolded.
        </p>
    </div>
</div>

<div class="flex flex-wrap">
    @foreach ($meetings as $meeting_type => $meetingGroup)
        <div class="card p-8 m-4">
            <div class="mb-4">
                <span class="text-xl font-extrabold text-grey-darkest">{{ $meeting_type }}</span>
            </div>
            <div class="leading-loose">
                @foreach ($meetingGroup as $meeting)
                    <?php /** @var \App\Model\Meeting $meeting */ ?>
                    <a href="{{ URL::route('meetings.show', $meeting->id) }}" class="no-underline text-grey-darkest hover:border-b-4 hover:border-grey @if ($meeting->date->gt(\Carbon\Carbon::now()->subMonths(3))) font-bold @endif">
                        {{ $meeting->date->toDateString() }} {{ $meeting->meeting_type }}
                    </a> <br />
                @endforeach
            </div>

        </div>
    @endforeach
</div>

@stop
