<?php

namespace Depotwarehouse\YEGVotes\Model;

class AttendanceRecord
{

    public $attendee;
    public $days_in_attendance;
    public $total_meetings;
    public $votes_in_attendance;
    public $total_votes;

    public function __construct($attendee, $days_present, $total_days, $votes_present, $total_votes)
    {
        $this->attendee = new CouncilMember($attendee);
        $this->days_in_attendance = $days_present;
        $this->total_meetings = $total_days;
        $this->votes_in_attendance = $votes_present;
        $this->total_votes = $total_votes;
    }

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

    public function voteFraction()
    {
        return number_format($this->votes_in_attendance, 0, '.', " ") . " / " . number_format($this->total_votes, 0, ".", " ");
    }

    public function votePercent()
    {
        if ($this->total_votes == 0) { throw new \Exception("Division by zero"); }
        return number_format(($this->votes_in_attendance / $this->total_votes) * 100);
    }

    public function attendanceFraction()
    {
        return "{$this->days_in_attendance} / {$this->total_meetings}";
    }

    public function attendancePercent()
    {
        return number_format(($this->days_in_attendance / $this->total_meetings) * 100);
    }

    public function sortValue()
    {
        // Because the attended over the total will be 1 or less, a value of 0 signals perfect attendance
        return 1 - ($this->votes_in_attendance / $this->total_votes);
    }
}
