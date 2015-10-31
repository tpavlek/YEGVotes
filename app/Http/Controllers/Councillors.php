<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Attendance;
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

    public function show($council_member)
    {
        $attendance = $this->attendanceModel->getRecordForCouncilMember($council_member);
        $bylaws = $this->agendaModel->bylaws()->paginate(15);

        return view('councillor.show')->with('voting_items', $bylaws)->with('attendanceRecord', $attendance);
    }

    public function noVotes($council_member)
    {
        $attendance = $this->attendanceModel->getRecordForCouncilMember($council_member);
        $bylaws = $this->agendaModel->voteAgainst($council_member)->paginate(15);

        return view('councillor.show')->with('voting_items', $bylaws)->with('attendanceRecord', $attendance);
    }

}
