@extends('layout')

@section('title')
- {{ $attendanceRecord->getAttendee() }}
@stop

@section('additional_nav')

@stop

@section('content')
    <div class="pure-g">
        <div class="pure-u-lg-1-2 pure-u-1">
            <div class="person-summary">
                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee() ])
                <div class="voting-summary">
                    <div class="attendance">
                        <h3>
                            Attendance: {{ $attendanceRecord->attendanceFraction() }}
                            (<span data-attendance-percent="{{ $attendanceRecord->attendancePercent() }}">
                            {{ $attendanceRecord->attendancePercent() }}%
                        </span>)
                        </h3>
                    </div>
                    @if(\Illuminate\Support\Str::contains(URL::current(), "no_votes"))
                        <a href="{{ URL::route('councillor.show', (string)$attendanceRecord->getAttendee()) }}" class="button">
                            <i class="fa fa-thumbs-up"></i> Show All Votes
                        </a>
                    @else
                        <a href="{{ URL::route('councillor.no_votes', (string)$attendanceRecord->getAttendee()) }}" class="button">
                            <i class="fa fa-thumbs-down"></i> Show Only No Votes
                        </a>
                    @endif

                    <div class="vote-container" style="margin-top: 0;">
                        @foreach ($voting_items as $voting_item)
                                <div class="vote" data-remote-url="{{ URL::route('agenda_item.show', $voting_item->id) }}">
                                    <div class="vote-summary">
                                        <div class="short-title">
                                            {{ $voting_item }}
                                        </div>
                                    </div>

                                    <div class="sub-votes">
                                        @foreach ($voting_item->getVoteGroupsForCouncillor($attendanceRecord->getAttendee()) as $key => $votes)
                                            <span class="vote {{ $key }}">
                                                {{ $key }}: {{ $votes->count() }}
                                            </span>
                                        @endforeach
                                    </div>

                                </div>


                        @endforeach
                    </div>
                </div>
                <div style="clear:both;"></div>
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

        </div>

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
