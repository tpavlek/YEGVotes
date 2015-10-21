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
        $voting_items = $this->agendaModel->bylaws()->take(10)->get([ 'agenda_items.*' ]);
        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('councillor_list')
            ->with('attendance', $records)
            ->with('voting_items', $voting_items);
    }

}
