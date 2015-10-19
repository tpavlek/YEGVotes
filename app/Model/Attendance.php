<?php

namespace Depotwarehouse\YEGVotes\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class Attendance extends Model
{

    public $table = "attendance";
    public $timestamps = false;

    protected $fillable = [ "meeting_id", "item_id", "attendee", "present" ];


    public function attendeeAtMeeting($attendee, $meeting_id)
    {
        return $this->newQuery()
            ->where('attendee', 'LIKE', $attendee)
            ->where('meeting_id', '=', $meeting_id)
            ->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRecordsForCouncil()
    {

        $results = $this->getConnection()->getPdo()->query("
            select attendee,
            (select count(id) from attendance where present = 1 and a.attendee = attendee) as present,
            count(id) as total
            from attendance as a
            where a.attendee like '%Coun%' or a.attendee like '%Mayor%'
            group by attendee;
        ");

        $attendance_records = new Collection();

        foreach ($results as $row) {
            $attendance_records->push(new AttendanceRecord($row['attendee'], $row['present'], $row['total']));
        }

        return $attendance_records->sortBy(function(AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->getWard();
        });
    }
}
