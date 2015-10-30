<a href="{{ URL::route('councillor.show', (string)$council_member) }}">
    <div class="person-details">
        <div class="council-member-img {{ $council_member->getShortWard() }}"></div>
        <div class="text">
            <h3>{{ $council_member->name }} <small>{{ $council_member->getWard() }}</small></h3>
            @if (isset($attendance) and $attendance)
                <h4>
                    Attendance: {{ $attendanceRecord->attendanceFraction() }}
                    (<span data-attendance-percent="{{ $attendanceRecord->attendancePercent() }}">
                                {{ $attendanceRecord->attendancePercent() }}%
                            </span>)
                </h4>
            @endif

        </div>

    </div>
</a>

