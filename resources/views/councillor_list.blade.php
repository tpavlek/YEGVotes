<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/all.css"/>
</head>
<body>
    <div class="body-wrapper">
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
                            <div class="vote">
                                <div class="short-title">Adoption of Agenda</div>
                                <span class="vote yea"></span>
                            </div>
                            WowWowWowWowWowWowWowWowWow
                            WowWowWowWowWowWowWowWowWowW
                            owWowWowWowWowWowWowWowWowWowW
                            owWowWowWowWowWowWowWowWow
                            WowWowWowWowW
                            owv
                        </div>
                        <div style="clear:both;"></div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</body>
</html>
