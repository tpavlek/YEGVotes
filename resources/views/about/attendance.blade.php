
<h3>Councillor and Mayor Attendance</h3>

<div class="flex row-wrap">
    @foreach($attendance_records as $attendance_record)
        @include('councilMemberPartial', [ 'council_member' => $attendance_record->getAttendee(), 'attendance' => $attendance_record ])
    @endforeach
</div>
<p>
    Easily see at a glance which councillors <strong>show up</strong>. Attendance is broken down by both
    meeting and individual votes, so if your councillor shows up to meetings, but leaves halfway
    through, you'll know!
</p>
