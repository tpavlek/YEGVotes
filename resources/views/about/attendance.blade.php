<div class="example">
    <div class="whitecard">
        <h3>Councillor and Mayor Attendance</h3>
        @foreach($attendance_records as $attendance_record)
            <div class="small-person-details">
                @include('councilMemberPartial', [ 'council_member' => $attendance_record->getAttendee(), 'link' => true, 'attendance' => $attendance_record ])
            </div>
        @endforeach
        <p>
            Easily see at a glance which councillors <strong>show up</strong>. Attendance is broken down by both
            meeting and individual votes, so if your councillor shows up to meetings, but leaves halfway
            through, you'll know!
        </p>
    </div>
</div>
