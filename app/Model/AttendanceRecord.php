<?php

namespace Depotwarehouse\YEGVotes\Model;

class AttendanceRecord
{

    /** @var string */
    public $attendee;
    public $days_in_attendance;
    public $total_meetings;
    public $ward;

    public function __construct($attendee, $days_present, $total_days)
    {
        $this->attendee = $attendee;
        $this->days_in_attendance = $days_present;
        $this->total_meetings = $total_days;

        $this->ward = Ward::getWardFor($attendee);
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
        return "ward{$this->ward}";
    }

    public function getWard()
    {
        if ($this->ward == "Mayor") {
            return $this->ward;
        }

        return "Ward {$this->ward}";
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
