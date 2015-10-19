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
                    @foreach ($voting_items as $voting_item)
                        <div class="vote">
                            <div class="short-title">{{ $voting_item->title }}</div>
                            @if ($voting_item->motions->count() > 1)
                                <span class="vote motion-list">Motions: {{ $voting_item->motions->count() }}</span>

                                <div class="sub-votes">
                                    @foreach ($voting_item->motions as $motion)
                                        <span class="vote {{ $voting_item->vote($attendanceRecord->getAttendee()) }}"
                                              data-remote-url="{{ URL::route('motion.show', $motion->id) }}">
                                            {{ $motion->vote($attendanceRecord->getAttendee()) }}
                                        </span>

                                    @endforeach
                                </div>

                            @else
                                <span class="vote {{ $voting_item->vote($attendanceRecord->getAttendee()) }}"
                                      data-remote-url="{{ URL::route('motion.show', $voting_item->motion->id) }}">
                                    {{ $voting_item->vote($attendanceRecord->getAttendee()) }}
                                </span>
                            @endif

                        </div>

                    @endforeach
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
            })
        });
    </script>
@stop
