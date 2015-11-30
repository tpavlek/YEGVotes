<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Attendance;
use Depotwarehouse\YEGVotes\Model\AttendanceRecord;
use Depotwarehouse\YEGVotes\Model\CouncilMember;
use Depotwarehouse\YEGVotes\Model\Meeting;

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
        $last_meeting = (new Meeting())->findLatestMeeting();
        $voting_items = $this->agendaModel->getInterestingAgendaItems($last_meeting);
        //$voting_items = $this->agendaModel->bylaws()->take(10)->get();
        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('overview')
            ->with('attendance', $records)
            ->with('voting_items', $voting_items);
    }

    public function about()
    {
        $attendance_records = $this->attendanceModel->getRecordsForCouncil();
        $attendance_records = $attendance_records->sortBy(function (AttendanceRecord $attendanceRecord) {
            return $attendanceRecord->sortValue();
        });

        // We only want the top attender and the bottom attender
        $attendance_records = collect([ $attendance_records->first(), $attendance_records->last() ]);

        $example_agenda_item = $this->agendaModel->find(48196);
        return view('about')
            ->with('attendance_records', $attendance_records)
            ->with('agenda_item', $example_agenda_item)
            ->with('councillor', new CouncilMember("D. Iveson - Mayor"))
            ->with('voting_items', $this->agendaModel->bylaws()->take(7)->get());
    }

}
