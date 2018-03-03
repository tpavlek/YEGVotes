<?php

namespace App\Template;

use App\Model\AttendanceRecord;

class AttendanceTemplate
{

    /**
     * @var AttendanceRecord
     */
    private $attendanceRecord;

    public function __construct(AttendanceRecord $attendanceRecord)
    {
        $this->attendanceRecord = $attendanceRecord;
    }

    public function render()
    {

        return view('councillor.attendance-partial')
            ->with('rating_color', $this->ratingColor())
            ->with('attendanceRating', $this->attendanceRating())
            ->with('attendance_record', $this->attendanceRecord);

    }

    private function attendanceRating()
    {
        $percent = $this->attendanceRecord->votePercent();
        if ($percent >= 99) {
            return "Flawless";
        }

        if ($percent >= 85) {
            return "Good";
        }

        if ($percent >= 70) {
            return "Average";
        }

        return "Poor";
    }

    public function ratingColor()
    {
        $percent = $this->attendanceRecord->votePercent();

        if ($percent >= 99) {
            return "text-green-dark";
        }

        if ($percent >= 95) {
            return "text-green-dark";
        }

        if ($percent >= 90) {
            return "text-green";
        }

        if ($percent >= 85) {
            return "text-green-light";
        }

        if ($percent >= 80) {
            return "text-orange-light";
        }

        if ($percent >= 75) {
            return "text-orange";
        }

        if ($percent >= 70) {
            return "text-orange-dark";
        }

        if ($percent >= 65) {
            return "text-red-light";
        }

        if ($percent >= 60) {
            return "text-red";
        }

        return "text-red-dark";
    }

}
