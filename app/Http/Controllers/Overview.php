<?php

namespace Depotwarehouse\YEGVotes\Http\Controllers;

use Depotwarehouse\YEGVotes\Model\AgendaItem;
use Depotwarehouse\YEGVotes\Model\Attendance;

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
        $voting_items = $this->agendaModel->getInterestingAgendaItems();
        //$voting_items = $this->agendaModel->bylaws()->take(10)->get();
        $records = $this->attendanceModel->getRecordsForCouncil();
        return view('overview')
            ->with('attendance', $records)
            ->with('voting_items', $voting_items);
    }

}
