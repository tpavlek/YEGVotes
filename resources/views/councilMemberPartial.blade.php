<?php /** @var \App\Model\AttendanceRecord $attendance_record */ ?>
<council-member
        link-url="{{ URL::route('councillor.show', $attendance_record->getAttendee()->name) }}"
        image-url="{{ $attendance_record->getAttendee()->getImageUrl() }}"
        council-member-name="{{ $attendance_record->getAttendee()->__toString() }}"
        council-member-ward="{{ $attendance_record->getWard() }}">
    <div>
        {!! (new App\Template\AttendanceTemplate($attendance_record))->render() !!}
    </div>
</council-member>
