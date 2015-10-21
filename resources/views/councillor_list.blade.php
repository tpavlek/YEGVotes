@extends('layout')

@section('content')
<div class="pure-g">
    @foreach ($attendance as $attendanceRecord)
        <div class="pure-u-1-2">
            <div class="person-summary">
                <div class="person-details">
                    <img src="/img/{{ $attendanceRecord->getShortWard() }}.jpg" />
                    <h3>{{ $attendanceRecord->getAttendee() }} <small>{{ $attendanceRecord->getWard() }}</small></h3>

                </div>
                <div class="voting-summary">
                    <div class="attendance">
                        <h3>
                            Attendance: {{ $attendanceRecord->attendanceFraction() }}
                            (<span data-attendance-percent="{{ $attendanceRecord->attendancePercent() }}">
                                {{ $attendanceRecord->attendancePercent() }}%
                            </span>)
                        </h3>
                    </div>
                    <h2>Recent Votes</h2>
                    <div class="vote-container" style="margin-top: 0;">
                        @foreach ($voting_items as $voting_item)

                            <div class="pure-g">
                                <div class="vote">
                                    <div class="vote-summary">
                                        <div class="pure-u-4-5">
                                            <div class="short-title" data-remote-url="{{ URL::route('agenda_item.show', $voting_item->id) }}">
                                                {{ $voting_item }}
                                            </div>
                                        </div>

                                        @if ($voting_item->interestingMotions()->count() > 1)
                                            <div class="pure-u-1-5">
                                                <span class="vote motion-list">Motions: {{ $voting_item->motions->count() }}</span>
                                            </div>
                                        @else
                                            <div class="pure-u-1-5">
                                                <span class="vote {{ $voting_item->interestingMotions()->first()->vote($attendanceRecord->getAttendee()) }}"
                                                      data-remote-url="{{ URL::route('motion.show', $voting_item->motion->id) }}">
                                                    {{ $voting_item->vote($attendanceRecord->getAttendee()) }}
                                                </span>
                                            </div>
                                        @endif

                                    </div>

                                    @if ($voting_item->interestingMotions()->count() > 1)
                                        <div class="sub-votes">
                                            @foreach ($voting_item->interestingMotions() as $motion)
                                                <div class="pure-u-1-5">
                                                    <span class="vote {{ $motion->vote($attendanceRecord->getAttendee()) }}"
                                                          data-remote-url="{{ URL::route('motion.show', $motion->id) }}">
                                                        {{ $motion->vote($attendanceRecord->getAttendee()) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>


                        @endforeach
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>

        </div>
    @endforeach

</div>

    <script>
        $(document).ready(function() {
            $("span.vote:not(.motion-list)").click(function() {
                window.location = $(this).data('remote-url');
            });

            $("div.short-title").click(function() {
                window.location = $(this).data('remote-url');
            })


        });
    </script>
@stop
