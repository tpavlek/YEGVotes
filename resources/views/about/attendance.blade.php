<?php /** @var \App\Model\AttendanceRecord $attendance_record */ ?>
<h3>Councillor and Mayor Attendance</h3>

<div class="flex row-wrap">
    @foreach($attendance_records as $attendance_record)
        <council-member
                link-url="{{ URL::route('councillor.show', $attendance_record->getAttendee()->__toString()) }}"
                img-url="{{ $attendance_record->getAttendee()->getImageUrl() }}"
                council-member-name="{{ $attendance_record->getAttendee()->name }}"
                council-member-ward="{{ $attendance_record->getWard() }}">
        </council-member>
    @endforeach
</div>
<p>
    Easily see at a glance which councillors <strong>show up</strong>. Attendance is broken down by both
    meeting and individual votes, so if your councillor shows up to meetings, but leaves halfway
    through, you'll know!
</p>
