@extends('layout')

@section('title', "{$attendanceRecord->getAttendee()} -")

@section('meta_description')
    About {{ $attendanceRecord->getAttendee() }}. {{ $attendanceRecord->getAttendee() }}'s attendance for City Council votes
    is {{ $attendanceRecord->votePercent() }}%. View the most recent voting record for this councillor.
@stop

@section('content')
    <div class="person-summary">
        @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'attendance' => $attendanceRecord ])

        <div class="voting-summary">
            @if(\Illuminate\Support\Str::contains(URL::current(), "no_votes"))
                <a href="{{ URL::route('councillor.show', (string)$attendanceRecord->getAttendee()) }}" class="waves-effect waves-light btn">
                    <i class="fa fa-thumbs-up"></i> Show All Votes
                </a>
            @else
                <a href="{{ URL::route('councillor.no_votes', (string)$attendanceRecord->getAttendee()) }}" class="waves-effect waves-light btn">
                    <i class="fa fa-thumbs-down"></i> Show Only Against Votes
                </a>
            @endif

            @include('councillor.votingSummaryPartial', [ 'councillor' => $attendanceRecord->getAttendee() ])
        </div>
        <ul class="pagination">
            <li>
                <a href="{{ $voting_items->previousPageUrl() }}"><i class="fa fa-arrow-left"></i></a>
            </li>
            @if ($voting_items->currentPage() != 1)
                <li>
                    <a href="{{ $voting_items->url(1) }}">{{ 1 }}</a>
                </li>
                <li>...</li>
            @endif
            @for($i = $voting_items->currentPage(); $i <= $voting_items->lastPage() - 1 && $i <= $voting_items->currentPage() + 6; $i++)
                <li @if ($voting_items->currentPage() == $i) class="active" @endif>
                    <a href="{{ $voting_items->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            @if ($voting_items->lastPage() != $i)
                <li>...</li>
            @endif
            <li @if ($voting_items->currentPage() == $i) class="active" @endif>
                <a href="{{ $voting_items->url($voting_items->lastPage()) }}">{{ $voting_items->lastPage() }}</a>
            </li>
            <li>
                <a href="{{ $voting_items->nextPageUrl() }}"><i class="fa fa-arrow-right"></i></a>
            </li>
        </ul>
    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $("div.vote").click(function() {
                window.location = $(this).data('remote-url');
            });

        });
    </script>
@stop
