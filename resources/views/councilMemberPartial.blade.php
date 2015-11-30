@if (isset($link) and $link)
    <a href="{{ URL::route('councillor.show', (string)$council_member) }}">
@endif
    <div class="person-details">
        <div class="council-member-img {{ $council_member->getShortWard() }}"></div>
        <div class="text">
            <h3>{{ $council_member->name }} @if($council_member->getWard() != "Mayor") <small>{{ $council_member->getWard() }}</small>@endif</h3>
            @if (isset($attendance) and $attendance)
                <h4>
                    Meetings: {{ $attendance->attendanceFraction() }}
                    (<span data-attendance-percent="{{ $attendance->attendancePercent() }}">
                                {{ $attendance->attendancePercent() }}%
                            </span>)
                </h4>
                <h4>
                    Votes: {{ $attendance->voteFraction() }}
                    (<span data-attendance-percent="{{ $attendance->votePercent() }}">
                                {{ $attendance->votePercent() }}%
                            </span>)
                </h4>
            @endif

        </div>

    </div>

@if (isset($link) and $link)
</a>
@endif

