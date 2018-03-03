<?php /** @var \App\Model\AttendanceRecord $attendance_record */ ?>
<div>
    <span>
        <span class="{{ $rating_color }} font-black">{{ $attendanceRating }}</span>
        <span class="font-thin text-grey-darkest">attendance</span>
    </span>
</div>
<div>
    <span class="{{ $rating_color }} font-extrabold">{{ $attendance_record->total_meetings - $attendance_record->days_in_attendance }}</span>
    <span class="font-thin text-grey-darkest">meetings missed (of {{ $attendance_record->total_meetings }})</span>
</div>
<div>
    <span class="{{ $rating_color }} font-extrabold">{{ $attendance_record->total_votes - $attendance_record->votes_in_attendance }}</span>
    <span class="font-thin text-grey-darkest">votes missed (of {{ $attendance_record->total_votes }})</span>
</div>
