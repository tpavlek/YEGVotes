<?php

namespace App\Http\Controllers;

use App\Model\AgendaItem;
use App\Model\Attendance;
use App\Model\AttendanceRecord;
use App\Model\CouncilMember;
use App\Model\Meeting;
use App\Model\Motion;

class Overview extends Controller
{

    protected $agendaModel;
    protected $attendanceModel;

    public function __construct(AgendaItem $agendaModel, Attendance $attendanceModel)
    {
        $this->agendaModel = $agendaModel;
        $this->attendanceModel = $attendanceModel;
    }

    public function show()
    {
        $last_meeting = (new Meeting())->latestBigCouncilMeeting();

        $groupedAgendaItems = $last_meeting->agenda_items()->interesting()->get()->groupBy(function (AgendaItem $agendaItem) {
            return $agendaItem->groupKey();
        });

        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('overview')
            ->with('attendance', $records)
            ->with('last_meeting', $last_meeting)
            ->with('groupedAgendaItems', $groupedAgendaItems);
    }

    public function about()
    {
        $attendance_records = $this->attendanceModel->getRecordsForCouncil();
        $attendance_records = $attendance_records->sortBy(function (AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->sortValue();
        });

        // We only want the top attender and the bottom attender
        $best_and_worst = collect([ $attendance_records->first(), $attendance_records->last() ]);

        $iveson_attendance = $attendance_records->first(function (AttendanceRecord $record) {
            return $record->getAttendee() == "D. Iveson - Mayor";
        });

        $example_agenda_item = $this->agendaModel->find(48196);
        return view('about')
            ->with('attendance_records', $best_and_worst)
            ->with('agenda_item', $example_agenda_item)
            ->with('example_motion', Motion::find('40791d0b-e3ee-4c47-baa4-29e54f6c7563'))
            ->with('councillor', new CouncilMember("D. Iveson - Mayor"))
            ->with('voting_items', $this->agendaModel->voteAgainst("D. Iveson - Mayor")->orderBy('meeting_id', 'DESC')->take(7)->get())
            ->with('iveson_attendance', $iveson_attendance);
    }

    public function stats()
    {
        return view('stats');
    }

}
