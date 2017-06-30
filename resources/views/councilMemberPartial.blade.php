<div class="card horizontal council-member">
    <div class="card-image">
        <img class="responsive-image" src="{{ $council_member->getImageUrl() }}">
    </div>
    <div class="card-stacked">
        <div class="card-content">
            <span class="card-title">{{ $council_member }} @if($council_member->getWard() != "Mayor")
                    <small>{{ $council_member->getWard() }}</small>@endif</span>

            @if(!isset($attendance) && $attendance = (new \Depotwarehouse\YEGVotes\Model\Attendance())->getRecordForCouncilMember((string)$council_member))
            @endif
            <div class="valign-wrapper">
                <div class="c100 p{{ $attendance->weightedVoteAttendancePercent() }}" data-attendance-percent="{{ $attendance->weightedVoteAttendancePercent() }}">
                    <span>{{ $attendance->votePercent() }}%</span>
                    <div class="slice">
                        <div class="bar"></div>
                        <div class="fill"></div>
                    </div>
                </div>
                <div class="attendance">
                    <p>
                        Meetings: {{ $attendance->meetingFraction() }}
                        (<span data-attendance-percent="{{ $attendance->weightedAttendancePercent() }}">{{ $attendance->attendancePercent() }}%</span>)
                    </p>
                    <p>
                        Votes: {{ $attendance->voteFraction() }}
                        (<span data-attendance-percent="{{ $attendance->weightedVoteAttendancePercent() }}">
                {{ $attendance->votePercent() }}%
            </span>)
                    </p>
                </div>
            </div>



        </div>
        <div class="card-action">
            <a href="{{ URL::route('councillor.show', (string)$council_member) }}"><i class="fa fa-check"></i> Voting Record</a>
        </div>
    </div>
</div>

