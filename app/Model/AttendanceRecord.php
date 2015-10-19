<?php

namespace Depotwarehouse\YEGVotes\Model;

class AttendanceRecord
{

    public $attendee;
    public $days_in_attendance;
    public $total_meetings;

    public function __construct($attendee, $days_present, $total_days)
    {
        $this->attendee = new CouncilMember($attendee);
        $this->days_in_attendance = $days_present;
        $this->total_meetings = $total_days;
    }

    /**
     * @return string
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    public function getShortWard()
    {
        return $this->attendee->getShortWard();
    }

    public function getWard()
    {
        return $this->attendee->getWard();
    }

    public function attendanceFraction()
    {
        return "{$this->days_in_attendance} / {$this->total_meetings}";
    }

    public function attendancePercent()
    {
        return number_format(($this->days_in_attendance / $this->total_meetings) * 100);
    }
}
