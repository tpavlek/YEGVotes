<?php

namespace App\Http\Controllers;

use App\Model\AgendaItem;
use App\Model\Attendance;
use App\Model\Councillor;
use App\Model\Meeting;
use App\Model\Vote;

class Councillors extends Controller
{


    public function __construct(Attendance $attendanceModel, AgendaItem $agendaModel)
    {
        $this->attendanceModel = $attendanceModel;
        $this->agendaModel = $agendaModel;
    }

    public function index()
    {

    }

    public function show(Councillor $councillor)
    {
        $attendance = $this->attendanceModel->getRecordForCouncilMember($councillor);
        $bylaws = $this->agendaModel->interesting()->hasVotes()->orderBy('meeting_id', 'DESC')->paginate(15);

        return view('councillor.show')
            ->with('voting_items', $bylaws)
            ->with('attendanceRecord', $attendance);
    }

    public function noVotes(Councillor $councillor)
    {
        $attendance = $this->attendanceModel->getRecordForCouncilMember($councillor);
        $bylaws = $this->agendaModel->voteAgainst($councillor->toString())->orderBy('meeting_id', 'DESC')->paginate(15);

        return view('councillor.show')->with('voting_items', $bylaws)->with('attendanceRecord', $attendance);
    }

}
