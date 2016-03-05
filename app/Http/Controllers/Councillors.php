<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Attendance;
use Depotwarehouse\YEGVotes\Model\Councillor;
use Depotwarehouse\YEGVotes\Model\Meeting;
use Depotwarehouse\YEGVotes\Model\Vote;

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
        $bylaws = $this->agendaModel->bylaws()->paginate(15);

        return view('councillor.show')->with('voting_items', $bylaws)->with('attendanceRecord', $attendance);
    }

    public function noVotes(Councillor $councillor)
    {
        $attendance = $this->attendanceModel->getRecordForCouncilMember($councillor);
        $bylaws = $this->agendaModel->voteAgainst($councillor->toString())->paginate(15);

        return view('councillor.show')->with('voting_items', $bylaws)->with('attendanceRecord', $attendance);
    }

}
