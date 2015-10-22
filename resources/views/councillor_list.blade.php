@extends('layout')

@section('title')
@stop

@section('content')
<div class="pure-g">
    @foreach ($attendance as $attendanceRecord)
        <div class="pure-u-xl-1-2 pure-u-1">
            <div class="person-summary">
                @include('councilMemberPartial', [ 'council_member' => $attendanceRecord->getAttendee(), 'link' => true ])

                <div class="voting-summary">
                    <div class="attendance">
                        <h3>
                            Attendance: {{ $attendanceRecord->attendanceFraction() }}
                            (<span data-attendance-percent="{{ $attendanceRecord->attendancePercent() }}">
                                {{ $attendanceRecord->attendancePercent() }}%
                            </span>)
                        </h3>
                    </div>
                    @include('votingSummaryPartial')
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
