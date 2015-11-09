<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Attendance;
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

}
