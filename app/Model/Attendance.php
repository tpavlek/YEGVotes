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

    public function getAttendee()
    {
        return new CouncilMember($this->attributes['attendee']);
    }

    public function attendeeAtMeeting($attendee, $meeting_id)
    {
        return $this->newQuery()
            ->where('attendee', 'LIKE', $attendee)
            ->where('meeting_id', '=', $meeting_id)
            ->first();
    }

    public function getRecordForCouncilMember($council_member)
    {
        $available_councillors = [
            "A. Knack - Councillor",
            "A. Sohi - Councillor",
            "B. Anderson - Councillor",
            "B. Esslinger - Councillor",
            "B. Henderson - Councillor",
            "D. Loken - Councillor",
            "E. Gibbons - Councillor",
            "M. Nickel - Councillor",
            "M. Oshry - Councillor",
            "M. Walters - Councillor",
            "S. McKeen - Councillor",
            "T. Caterina - Councillor",
            "D. Iveson - Mayor"
        ];
        $council_member = (string)$council_member;
        if (!in_array($council_member, $available_councillors)) {
            throw new \InvalidArgumentException("Attempted to query an illegal council member");
        }

        $results = $this->getConnection()->getPdo()->query("
            select a.attendee, vote_query.votes_present as votes_present, vote_query.total_votes as total_votes,
            (select count(id) from attendance where present = 1 and a.attendee = attendee) as meetings_present,
            count(id) as total_meetings
            from attendance as a,
            (select voter, count(v.id) as total_votes,
                (select count(id) from votes where vote not in ('Absent', 'Off the Dais') and voter = v.voter) as votes_present
                from votes v where voter like '%{$council_member}%') as vote_query
            where a.attendee like '%{$council_member}%';
        ");

        foreach ($results as $row) {
            return new AttendanceRecord(
                $row['attendee'],
                $row['meetings_present'],
                $row['total_meetings'],
                $row['votes_present'],
                $row['total_votes']
            );
        }

        return null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRecordsForCouncil()
    {
        $results = $this->getConnection()->getPdo()->query("
            select attendee, vote_query.votes_present as votes_present, vote_query.total_votes as total_votes,
            (select count(id) from attendance where present = 1 and a.attendee = attendee) as meetings_present,
            count(id) as total_meetings
            from attendance as a,
            (select voter, count(v.id) as total_votes,
                (select count(id) from votes where vote not in ('Absent', 'Off the Dais') and v.voter = voter) as votes_present
                from votes v
                group by voter) as vote_query
            where (a.attendee like '%Coun%' or a.attendee like '%Mayor%') and vote_query.voter = a.attendee
            group by attendee;
        ");

        $attendance_records = new Collection();

        foreach ($results as $row) {
            $attendance_records->push(
                new AttendanceRecord(
                    $row['attendee'],
                    $row['meetings_present'],
                    $row['total_meetings'],
                    $row['votes_present'],
                    $row['total_votes']
                )
            );
        }

        return $attendance_records->sortBy(function(AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->getAttendee()->getWardNumber();
        });
    }
}
